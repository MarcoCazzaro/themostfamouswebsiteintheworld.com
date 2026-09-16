<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use App\Livewire\ProfileUpdateSocialLinksForm;
use App\Livewire\ProfileUpdateTagsForm;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;
use Livewire;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);

        Livewire::component('profile.update-tags-form', ProfileUpdateTagsForm::class);
        Livewire::component('profile.update-social-links-form', ProfileUpdateSocialLinksForm::class);
    }

    /**
     * Configure the permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
