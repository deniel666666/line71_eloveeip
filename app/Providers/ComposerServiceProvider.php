<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {   
        /*admin layouts*/
		view()->composer(
			[
                'layouts.masterAdmin',
                'admin.mailbox.mailbox',
            ],
            'App\Http\ViewComposers\ProfileAdminComposer'
		);

        /*seo layouts*/
        view()->composer(
            [
                'client.layouts.seo', 
                'client.layouts.footer', 
                'client.privacy_policy', 

                'emails.contact_H',
                'emails.contact_A',
                'emails.contact',

                'emails.activeCode',
                'emails.forgetPassword',
                'emails.notify_show',

                'emails.order',
                'emails.order_H'

            ], 'App\Http\ViewComposers\ProfileSeoComposer'
        );

        /*lang menu*/
        view()->composer(
            [
                'client.layouts.nav',
                'client.layouts.footer',
            ], 'App\Http\ViewComposers\ProfileNavComposer'
        );

        view()->composer(
            [
                'client.layouts.marquee',
            ], 'App\Http\ViewComposers\ProfileMarqueeComposer'

        );

        /*public cms layouts*/
        view()->composer(
            [
                'client.layouts.seo', 
                'client.faq',
                'client.case',
                'client.layouts.nav',
                'client.layouts.footer',
                'client.about_us_contact',
            ], 'App\Http\ViewComposers\ProfilePublicCmsComposer'
        );

        /*footer gallery link*/
        view()->composer(
            [
                'client.layouts.footer', //footer頁面會用到
            ], 'App\Http\ViewComposers\ProfileFooterLinkComposer'
        );
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

