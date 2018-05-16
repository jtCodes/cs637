<!DOCTYPE html>
<html>
    <body>
        <main>
            <h1>Database Error</h1>
            <p>There was an error accessing the database.</p>
            <p>The database must be installed using database/createdb.sql</p>
            <p> (after database/dev_setup.sql on your dev system.)</p>
            <p>Error message: <?php echo $error_message; ?></p>
           <?php
           echo '<p> at line ' . $e->getLine() . ' in file ' . $e->getFile() . '</p>';
                echo '<p> full backtrace:<br>';
                echo str_replace("\n", '<br>', $e->getTraceAsString());
                echo '</p>';
             ?> 
            <p> <?php debug_print_backtrace(); ?></p>
        </main>
    </body>
</html>
