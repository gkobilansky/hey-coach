<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\Task\TaskRepositoryContract;

class TaskHeaderComposer
{
    /**
     * The task repository implementation.
     *
     * @var taskRepository
     */
    protected $tasks;

    /**
     * Create a new profile composer.
     *
     * @param taskRepository|TaskRepositoryContract $tasks
     */
    public function __construct(TaskRepositoryContract $tasks)
    {
        $this->tasks = $tasks;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $tasks = $this->tasks->find($view->getData()['tasks']['id']);
        /**
         * [User assigned the task]
         * @var contact
         */
       
        $contact = $tasks->user;
        $athlete = $tasks->athlete;
        
        $view->with('contact', $contact);
        $view->with('athlete', $athlete);
    }
}
