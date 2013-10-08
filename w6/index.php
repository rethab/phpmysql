<?php

require_once('blog.php');

head('Blog');

if (!is_logged_in()): ?>
        <a href="login.php">Login</a> to create<br />
<?php else: ?>
        <p>Hello <?= get_name() ?> </p>
        <p>
                Create <a href="create.php">new entry</a> or <a href="logout.php">log out</a>
        </p>
<?php endif; ?>

<?php

$entries = get_all_entries();

if (empty($entries)): ?>
        <h2>No entries</h2>
<?php else: ?>

        
        <?php
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
        ?>


<?php endif;

foot();
