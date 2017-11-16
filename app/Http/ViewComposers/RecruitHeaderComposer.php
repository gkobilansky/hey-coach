<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\Recruit\RecruitRepositoryContract;

class RecruitHeaderComposer
{
    /**
     * The task repository implementation.
     *
     * @var taskRepository
     */
    protected $recruit;

    /**
     * Create a new profile composer.
     * RecruitHeaderComposer constructor.
     * @param RecruitRepositoryContract $lead
     */
    public function __construct(RecruitRepositoryContract $recruit)
    {
        $this->recruit = $recruit;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $recruit = $this->recruit->find($view->getData()['recruit']['id']);
        /**
         * [User assigned the task]
         * @var contact
         */
       
        $contact = $recruit->user;
        $athlete = $recruit->athlete;
        
        $view->with('contact', $contact);
        $view->with('athlete', $athlete);
    }
}
