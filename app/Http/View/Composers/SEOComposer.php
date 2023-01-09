<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

class SEOComposer
{
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $request = request();
        /*
        $URL_segments = $request->segments();
        if (request()->is('en') || request()->is('en/*')) {
            $current_language = 'en_GB';
        } else {
            $current_language = 'it_IT';
        }
        */
        $current_language = config('app.locale');
        \Carbon\Carbon::setLocale($current_language);
        try {
            $seo_args = [
                'SNAIL_SEO_LANGUAGE' => $current_language,
                'SNAIL_SEO_TITLE' => trans('seo.default_title'),
                'SNAIL_SEO_TITLE_FULL' => trans('seo.default_title'),
                'SNAIL_SEO_DESCRIPTION' => trans('seo.default_description'),
                'SNAIL_SEO_KEYWORDS' => trans('seo.default_keywords'),
            ];

            $path_without_locale = explode("/", request()->path());
            //array_shift($path_without_locale);
            $seo_key = 'seo.' . implode(".", $path_without_locale);
            $args = ['title', 'description', 'keywords'];
            foreach ($args as $arg) {
                $seo_full_key = $seo_key . "_" . $arg;
                switch (true) {
                    case \Lang::has($seo_full_key):
                        $seo_args["SNAIL_SEO_".strtoupper($arg)] = trans($seo_full_key);
                        break;
                    case request()->route()->getName() === 'suggest':
                        //dd($view);
                        /*
                        $seo_args["SNAIL_SEO_".strtoupper($arg)] = trans('seo.suggest_user_' . $arg, [
                                'name' => $view->user->name
                            ]);
                            */
                        break;
                    /*
                    case isset($view->work):
                        $seo_args["SNAIL_SEO_".strtoupper($arg)] = trans('seo.work_' . $arg, [
                                'title' => $view->work->title,
                                'work_description' => strip_tags($view->work->description . ' ' . $view->work->full_info),
                                'work_keywords' => $view->work->techniques()->first()->label
                            ]);
                        break;
                    */
                    
                    default:
                        //
                        break;
                }
            }
        } catch (\Exception $e) {
            report($e);
        }
        $seo_args['SNAIL_SEO_DESCRIPTION'] = \Str::limit($seo_args['SNAIL_SEO_DESCRIPTION'], 151);
        $seo_args['SNAIL_SEO_TITLE_FULL'] = $seo_args['SNAIL_SEO_TITLE'];
        if (!\Str::contains($seo_args['SNAIL_SEO_TITLE_FULL'], 'TMFWITW')) {
            $seo_args['SNAIL_SEO_TITLE_FULL'] = $seo_args['SNAIL_SEO_TITLE_FULL'] . " | TMFWITW";
        }
        $view->with($seo_args);
    }
}
