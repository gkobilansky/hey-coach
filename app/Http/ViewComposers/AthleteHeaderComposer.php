<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\Athlete\AthleteRepositoryContract;

class AthleteHeaderComposer
{
    /**
     * The athlete repository implementation.
     *
     * @var AthleteRepository
     */
    protected $athletes;

    /**
     * Create a new profile composer.
     *
     * @param AthleteRepository|AthleteRepositoryContract $athletes
     */
    public function __construct(AthleteRepositoryContract $athletes)
    {
        $this->athletes = $athletes;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $athletes = $this->athletes->find($view->getData()['athlete']['id']);
        /**
         * [User assigned the athlete]
         * @var contact
         */
        $contact = $athletes->user;

        $view->with('contact', $contact);
    }
}
