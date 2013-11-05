<?php if (!isset($entries) || empty($entries)): ?>
    <p>Keine Einträge vorhanden</p>
<?php else:

        $first = true;
        foreach ($entries as $entry) {

               // display hr before each except first
               if (!$first) { echo '<hr>'; } 
               else { $first = false; }

               echo '<h2>' . htmlspecialchars($entry['title']) . '</h2>';
               echo '<p>' . htmlspecialchars($entry['content']) . '<br />';
               echo ' <i>Created by ' . htmlspecialchars($entry['author']);
               echo ' (' . $entry['created'] . ')';
               if (is_logged_in()) {
                        echo '<br />';
                        echo '<a href="edit.php?id='.$entry['id'].'">Edit</a> ';
                        echo '<a href="delete.php?id='.$entry['id'].'">Delete</a>';
               }
               echo '</i></p>';
        }
endif; ?>
