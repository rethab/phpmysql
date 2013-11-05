<?php if (!isset($this->_['posts']) || empty($this->_['entries'])): ?>
    <p>Keine Einträge vorhanden</p>
<?php else:

        $first = true;
        foreach ($this->_['posts'] as $post) {

               // display hr before each except first
               if (!$first) { echo '<hr>'; } 
               else { $first = false; }

               echo '<h2>' . htmlspecialchars($post['title']) . '</h2>';
               echo '<p>' . htmlspecialchars($post['content']) . '<br />';
               echo ' <i>Created by ' . htmlspecialchars($post['author']);
               echo ' (' . $post['created'] . ')';
               if (is_logged_in()) {
                        echo '<br />';
                        echo '<a href="edit.php?id='.$post['id'].'">Edit</a> ';
                        echo '<a href="delete.php?id='.$post['id'].'">Delete</a>';
               }
               echo '</i></p>';
        }
endif; ?>
