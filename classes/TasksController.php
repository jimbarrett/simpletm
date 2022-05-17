<?php 

class TasksController {

    public function index() {
        $filter = $_GET['filter'];
        $search = $_GET['search']; 
        $task = new Task();
        $tasks = $task->findByOwner($_SESSION['user']['id'], $filter, $search);

        $tasks = $this->additionalVariables($tasks);
        
        include('views/tasks.php');
    }

    public function delete() {
        echo json_encode(['task' => $_POST['task']]);
        $task = new Task();
        $task->delete($_POST['task']);
    }

    public function showform() {
        include('views/partials/add-task-form.php');
    }

    public function savenew() {
        $task = new Task();
        $saved = $task->saveNew($_SESSION['user']['id'], $_POST['title'], $_POST['due']);
        echo json_encode($saved);
    }

    public function updatetitle() {
        $task = new Task();
        $saved = $task->updateTitle($_POST['title'],$_POST['task']);
        echo json_encode($saved);
    }

    public function updateduedate() {
        $task = new Task();
        $saved = $task->updateDueDate($_POST['due_date'], $_POST['task']);
        echo json_encode($saved);
    }

    public function markcomplete() {
        $task = new Task();
        $saved = $task->markComplete($_POST['task']);
        echo json_encode($saved);
    }

    public function additionalVariables($tasks) {
        $now = new DateTime();
        // add new variables that I'll want to display
        foreach($tasks as &$t) {
            $dt = new DateTime($t['due_date']);
            // get date value that I can add to date input
            $t['due_field_value'] = $dt->format('Y-m-d');
            // format due_date
            $t['due_string'] = date('D M j, Y', strtotime($t['due_date']));
            //format deleted_date
            if($t['deleted_date']) {
                $t['deleted_string'] = date('D M j, Y', strtotime($t['deleted_date']));
            } else {
                $t['deleted_string'] = false;
            }
            // get num days until due
            $in = $dt->diff($now);
            // $t['due_days'] = intval($in->format("%a"));
            $days = intval($in->format("%a"));
            if($now > $dt) {
                $days = $days * -1;
            }
            $t['due_days'] = $days;
            // class to style due date based on days remaining
            if($t['due_days'] < 1) {
                $t['due_class'] = 'btn btn-xs btn-danger';
            } else if($t['due_days'] < 7) {
                $t['due_class'] = 'btn btn-xs btn-warning';
            } else {
                $t['due_class'] = 'btn btn-xs btn-success';
            }
        }
        return $tasks;
    }

}