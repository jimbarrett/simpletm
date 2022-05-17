// init page scripts
const init = () => {
    // filters
    let filterForm = document.getElementById('filterForm');
    document.getElementById('taskFilterSelect').addEventListener('change', () => {
        filterForm.submit();
    });

    // button to open 'add a task' dialog
    let taskadd = document.getElementById('taskadd');
    taskadd.addEventListener('click', () => {
        showNewTaskForm();
    });

    // init task buttons
    initTaskButtons();
    initTaskEdit();
}

// init inline fields to edit task title and due date.
const initTaskEdit = () => {
    // edit title
    let titles = document.getElementsByClassName('display-name');
    for(let i = 0; i < titles.length; i++) {
        // remove existing keypress listener if one exists
        // this is just in case I want to dynamically load these later.
        titles[i].removeEventListener('keypress', function(e) {
            if(e.which === 13) {
                e.preventDefault();
                updateTaskTitle(e);
                e.target.blur();
            }
        });
        titles[i].addEventListener('keypress', function(e) {
            if(e.which === 13) {
                e.preventDefault();
                updateTaskTitle(e);
                e.target.blur();
            }
        });
    }
    // edit due date
    let dd = document.getElementsByClassName('display-due');
    for(let i = 0; i < dd.length; i++) {
        dd[i].removeEventListener('click',openEditDueDate);
        dd[i].addEventListener('click',openEditDueDate);
    }
    // save updated due date
    let sdd = document.getElementsByClassName('submit-due-date');
    for(let i = 0; i < sdd.length; i++) {
        sdd[i].removeEventListener('click', updateDueDate);
        sdd[i].addEventListener('click', updateDueDate);
    }
}

// change due date for an existing task
const updateDueDate = (e) => {
    let i = e.target,  
        t = i.getAttribute('task'),
        dd = document.getElementById('due-date-' + t).value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST','tasks/updateduedate');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        // I hate to reload the window here but I'm pressed for time. 
        // If I were spending more time on this I would definitely want
        // to dynamically reload all task-well elements when they are updated. 
        location.reload();
    }
    xhr.send(encodeURI('task=' + t + '&due_date=' + dd));
}
// show the date input field to update the due date
const openEditDueDate = (e) => {
    // e.target.parentElement.classList.add('open');
    e.target.closest('.task-due-date').classList.add('open');
}
// save new title for an existing task
const updateTaskTitle = (e) => {
    let v = e.target.innerHTML,
        i = e.target.getAttribute('task');
    var xhr = new XMLHttpRequest();
    xhr.open('POST','tasks/updatetitle');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        console.log(xhr.status);
        console.log(xhr.responseText);
    }
    xhr.send(encodeURI('task=' + i + '&title=' + v));
}

// init buttons within each task-well
const initTaskButtons = () => {
    // open delete/complete dialog
    let delBtns = document.getElementsByClassName('open-dialog');
    for(let i = 0; i < delBtns.length; i++) {
        delBtns[i].removeEventListener('click', opendialog);
        delBtns[i].addEventListener('click', opendialog);
    }
    // delete confirm button 
    let con = document.getElementsByClassName('delete-confirmed');
    for(let i = 0; i < con.length; i++) {
        con[i].removeEventListener('click', deleteTask);
        con[i].addEventListener('click', deleteTask);
    }
    // delete/complete cancel button 
    let can = document.getElementsByClassName('dialog-cancelled');
    for(let i = 0; i < can.length; i++) {
        can[i].removeEventListener('click', cancelDelete);
        can[i].addEventListener('click', cancelDelete);
    }
    // complete confirm button
    let mc = document.getElementsByClassName('complete-confirmed');
    for(let i = 0; i < mc.length; i++) {
        mc[i].removeEventListener('click', markCompleted);
        mc[i].addEventListener('click', markCompleted);
    }
}

const markCompleted = (e) => {
    let t = e.target.getAttribute('task');
    var xhr = new XMLHttpRequest();
    xhr.open('POST','tasks/markcomplete');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        e.target.closest('.task-well').remove();
    }
    xhr.send(encodeURI('task=' + t));
}

const opendialog = (e) => {
    e.target.parentElement.classList.add('open');
}

const deleteTask = (e) => {
    var xhr = new XMLHttpRequest();
    var taskid = e.target.getAttribute('task');
    xhr.open('POST','tasks/delete');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        e.target.closest('.task-well').remove();
    }
    xhr.send(encodeURI('task=' + taskid));
}
const cancelDelete = (e) => {
    e.target.parentElement.parentElement.classList.remove('open');
}

const showNewTaskForm = () => {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'task/showform');
    xhr.onload = function() {
        document.getElementById('addTaskForm').innerHTML = xhr.responseText;
        document.getElementById('addTaskForm').style.display = 'block';
        initAddTaskButtons();
    }
    xhr.send();
}

const initAddTaskButtons = () => {
    document.getElementById('addNew').addEventListener('click', function() {
        let title = document.getElementById('newTaskTitle'),
            due = document.getElementById('newTaskDate');
        if(title.value.length < 5) {
            alert('Title is required and must be at least 5 characters long.');
            return false;
        } else if(due.value.length < 10) {
            alert('Due Date is a required field');
            return false;
        }

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'task/savenew');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            // I hate doing reload here. If I had more time I would make these dynamic.
            location.reload();
        }
        xhr.send(encodeURI('title=' + title.value + '&due=' + due.value));

    });
    document.getElementById('cancelAddNew').addEventListener('click', function() {
        document.getElementById('addTaskForm').innerHTML = '';
        document.getElementById('addTaskForm').style.display = 'none';
    });
}



window.onload = init;