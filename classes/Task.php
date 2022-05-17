<?php 

class Task extends Model {

    public function findByOwner($user_id, $filter=false, $search=false) {
        $sql = "SELECT id, name, complete, due_date, deleted_date, created_date FROM tasks WHERE owner_id = ?";
        // add search string to query
        if($search) {
            $sql .= ' AND name LIKE "%' . $search . '%"';
            // if we are doing a text search I want to bypass filter checks and return results
            // for active, deleted, or complete.
            $filter = 'override';
        }
        // add filter to query
        switch($filter) {
            case 'deleted':
                $sql .= " AND deleted_date IS NOT NULL";
                break;
            case 'complete':
                $sql .= " AND complete = 1";
                break;
            case 'override':
                $sql .= "";
                break;
            default: 
                $sql .= " AND deleted_date IS NULL AND complete = 0";
                break;
        }


        $sql .= " ORDER BY due_date ASC";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('i',$user_id);
        $stmt->execute();
        $arr = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $arr;
    }

    public function delete($id) {
        $stmt = $this->mysqli->prepare('UPDATE tasks SET deleted_date=NOW() WHERE id=?');
        $stmt->bind_param('i',$id);
        $stmt->execute();
    }

    public function saveNew($user_id, $name, $due_date) {
        $stmt = $this->mysqli->prepare('INSERT INTO tasks (owner_id, name, due_date, created_date) VALUES (?, ?, ?, NOW())');
        $stmt->bind_param('iss',$user_id, $name, $due_date);
        $stmt->execute();
    }

    public function updateTitle($title, $id) {
        $stmt = $this->mysqli->prepare('UPDATE tasks SET name=? WHERE id=?');
        $stmt->bind_param('si',$title, $id);
        $stmt->execute();
    }

    public function updateDueDate($due_date, $id) {
        $stmt = $this->mysqli->prepare('UPDATE tasks SET due_date=? WHERE id=?');
        $stmt->bind_param('si',$due_date,$id);
        $stmt->execute();
    }

    public function markComplete($id) {
        $stmt = $this->mysqli->prepare('UPDATE tasks SET complete=1 WHERE id=?');
        $stmt->bind_param('i',$id);
        $stmt->execute();
    }

}