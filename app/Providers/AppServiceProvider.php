<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		view()->composer('youths.form', function($view){
            $view->with('nationalityList', \App\Nationality::lists('name', 'id'));
            $view->with('ethnicityList', \App\Ethnicity::lists('name', 'id'));
            $view->with('faithList', \App\Faith::lists('name', 'id'));
            $view->with('parentList', \App\YouthParent::get()->lists('name', 'id'));
            $view->with('surgeryList', \App\Surgery::lists('address_line1', 'id'));
            $view->with('sectionList', \App\Section::lists('name', 'id'));
            $view->with('disabilityList', \App\Disability::lists('name', 'id'));
        });

        view()->composer('comm.form', function($view){
            $view->with('sectionList', \App\Section::all());
            $view->with('smsFromList', \App\SmsFrom::get()->lists('descriptor', 'id'));
            $view->with('emailFromList', \App\EmailFrom::get()->lists('descriptor', 'id'));
        });

        view()->composer('me.filter', function($view){
            $view->with('sectionList', \App\Section::get()->lists('name', 'id'));
        });

        view()->composer('badge.youth.massAssign', function($view){
            $view->with('badgeList', \App\Badge::get()->lists('name', 'id'));
        });
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);
	}

}
