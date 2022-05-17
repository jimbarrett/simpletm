<?php require('includes/head.php'); ?>

<div class="container-fluid">
    <div class="row sub-bar">
        <div id="filters" class="col-xs-4">
            <form action="/" method="GET" id="filterForm">
                <select name="filter" id="taskFilterSelect" class="form-control">
                    <option value="active" <?php echo ($filter == 'active' || !$filter) ? 'selected' : ''; ?>>In Progress</option>
                    <option value="complete" <?php echo $filter == 'complete' ? 'selected' : ''; ?>>Complete</option>
                    <option value="deleted" <?php echo $filter == 'deleted' ? 'selected' : ''; ?>>Deleted</option>
                </select>
            </form>
        </div>

        <div id="search" class="col-xs-4 text-center">
            <form action="/" method="GET"> 
                <div class="row">
                    <div>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search" name="search"/>
                        <div class="input-group-btn">
                        <button class="btn btn-primary" type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </div>
                    </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-xs-4 text-right">
            <button class="btn btn-sm btn-primary pull-right" id="taskadd" title="Add a Task"><i class="glyphicon glyphicon-plus"></i> Add a New Task</button>
        </div>
    </div>
</div>

<div class="container">

    <div class="row sub-bar clearfix">
        <div class="col-md-12">
            <?php 
                if($search) {
            ?>
                Showing results for search term: <strong><?php echo $search; ?></strong>
            <?php
                }
            ?>
            
        </div>
    </div>

    <div id="tasks-wrapper">

        <div class="well task-well" id="addTaskForm"></div>

<?php 
    foreach($tasks as $task) {
?>
        <div class="well task-well">
            <div id="action-buttons">
            <?php 
                if(!$task['complete']) {
            ?>
                <div class="task-dialog">
                    <span class="confirm">
                        <button class="btn btn-xs btn-success complete-confirmed" task="<?php echo $task['id']; ?>">Completed</button> <button class="btn btn-xs btn-danger dialog-cancelled">Cancel</button>
                    </span>
                    <span class="glyphicon glyphicon-ok-sign open-dialog text-info" taskid="<?php echo $task['id']; ?>" title="Mark Complete"></span>
                </div>
            <?php
                }
            ?>
            <?php 
                if(!$task['deleted_date']) {
            ?>
                <div class="task-dialog">
                    <span class="confirm">
                        <button class="btn btn-xs btn-success delete-confirmed" task="<?php echo $task['id']; ?>">Delete</button> <button class="btn btn-xs btn-danger dialog-cancelled">Cancel</button>
                    </span>
                    <span class="glyphicon glyphicon-remove-sign open-dialog text-danger" taskid="<?php echo $task['id']; ?>" title="Delete this task"></span>
                </div>
            <?php 
                }
            ?>
            </div>
            <h3 class="display-name" contenteditable="true" task="<?php echo $task['id']; ?>"><?php echo $task['name']; ?></h3>
        <?php 
            if(!$task['deleted_date'] && $task['complete'] == 0) {
        ?>
            <div class="row">
                <div class="col-sm-6 task-due-date">
                    <div class="display-due">
                        <strong>Due: <?php echo $task['due_string']; ?></strong> 
                        <span class="<?php echo $task['due_class']; ?>">
                            <?php echo $task['due_days'] < 1 ? ' ' . $task['due_days']*-1 . ' days Overdue ' : $task['due_days'] . ' days'; ?>
                        </span>
                    </div>
                    <div class="edit-due">
                        <input type="date" class="form-control" id="due-date-<?php echo $task['id']; ?>" value="<?php echo $task['due_field_value']; ?>">
                        <span class="glyphicon glyphicon-ok-sign submit-due-date" task="<?php echo $task['id']; ?>"></span>
                    </div>
                </div>
            </div>
        <?php 
            }
        ?>
        </div>
<?php
    }

    if(count($tasks) < 1) {
?>
    <h3>No Tasks Found.</h3>
<?php
    }
?>

    </div>
</div>

<script src="resources/js/tasks.js"></script>

<?php require('includes/foot.php'); ?>