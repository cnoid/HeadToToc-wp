<?php
/**
* Plugin Name: Head to Link
* Plugin URI: https://github.com/aerowa/head-to-toc-wp
* Description: Assigns Head tags to links on selected pages as 'Table of Contents'. Please see readme on plugin URL.
* Version: 0.4.1
* Author: Mimmikk.
* Author URI: https://github.com/aerowa
* License: GPL2
*/

// Enqueue the CSS file
function myplugin_enqueue_styles() {
    $plugin_url = plugin_dir_url( __FILE__ );
    wp_enqueue_style( 'mypluginstyle', $plugin_url . 'style.css', array(2464, 2934), '1.0', 'all');
}
add_action( 'wp_enqueue_scripts', 'myplugin_enqueue_styles' );

function table_of_contents() {
    // array of page IDs
    $ids = array(PAGEID);
    // get current page ID
    $current_id = get_the_ID();

    // check if the current page ID is in the array of IDs
    if(in_array($current_id, $ids)) {
        ?>
        <script>
        window.onload = function() {
            // get all header tags
            var headerTags = document.querySelectorAll("h1, h2, h3, h4, h5, h6");

            // create a new table
            var table = document.createElement("table");

            // loop over each header tag
            headerTags.forEach(function(header) {

                // check innerText for unwanted elements
                if (header.innerText !== "Elements to copy:") {

                    // create a new row and cell
                    var row = document.createElement("tr");
                    var cell = document.createElement("td");

                    // create a new link with the header text and id
                    var link = document.createElement("a");
                    link.setAttribute("href", "#" + header.id);
                    link.innerText = header.innerText;

                    // append the link to the cell, the cell to the row, and the row to the table
                    cell.appendChild(link);
                    row.appendChild(cell);
                    table.appendChild(row);
                }
            });

            // get the div with id "tocBox"
            var tocBox = document.getElementById("tocBox");

            // append the table to the div
            tocBox.appendChild(table);
        }
        </script>
        <?php
    }
}

add_action('wp_footer', 'table_of_contents');
?>
