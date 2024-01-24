<?php
/*Fechar Ligação ao sql*/
    if (!function_exists('close_connection')) {
        function close_connection($conn) {
            if (!mysqli_connect_errno()) {
                mysqli_close($conn);
            }
        }
    }
?>