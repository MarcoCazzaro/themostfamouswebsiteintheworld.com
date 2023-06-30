<?php

namespace App\Actions\Fortify;

use App\Enums\UserInfoTypes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Spatie\ResponseCache\Facades\ResponseCache;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        if (isset($input['tags'])) {
            $user->syncTags($input['tags']);
        } elseif (isset($input['socialLinks'])) {
            Validator::make($input, [
                'socialLinks.*' => ['url'],
            ])->validateWithBag('updateProfileInformation');
            $data = [];
            $user->socialLinks()->delete();
            foreach ($input['socialLinks'] as $socialLink) {
                if ($socialLink) {
                    $socialName = getSocialNameFromLink($socialLink);
                    if (array_search($socialName, array_column($data, 'name')) === false) {
                        $data[] = [
                            'user_id' => $user->id,
                            'type' => UserInfoTypes::SOCIAL->value,
                            'name' => $socialName,
                            'value' => $socialLink,
                        ];
                    }
                }
            }
            $user->socialLinks()->upsert(
                $data,
                ['user_id', 'type', 'name'],
                ['value']
            );
        } else {
            Validator::make($input, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            ])->validateWithBag('updateProfileInformation');

            if (isset($input['photo'])) {
                $user->updateProfilePhoto($input['photo']);
            }

            if ($input['email'] !== $user->email &&
                $user instanceof MustVerifyEmail) {
                $this->updateVerifiedUser($user, $input);
            } else {
                $user->forceFill([
                    'name' => $input['name'],
                    'email' => $input['email'],
                ])->save();
            }
        }
        setUserOption('profile.completed', 1);
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
