$childrem = mysqli_query($conn, "SELECT Mastercart_id FROM cartitem WHERE Item_id = '$item'");
        while ($chrow = mysqli_fetch_assoc($childrem)):
          $mast = $chrow['Mastercart_id'];

          // Check if the entry exists before attempting to delete
          $check_query = "SELECT COUNT(*) AS count FROM cartitem WHERE Item_id = '$item' AND Mastercart_id = '$mast'";
          $check_result = mysqli_query($conn, $check_query);
          $check_row = mysqli_fetch_assoc($check_result);

          if ($check_row['count'] > 0) {
            // Delete items with the specific Item_id and NOT in the current Mastercart_id
            $rem = mysqli_query($conn, "DELETE FROM cartitem WHERE Item_id = '$item' AND Mastercart_id != '$mastercartID'");

            // Count remaining items for the current Mastercart_id
            $remaining_items_query = mysqli_query($conn, "SELECT COUNT(*) AS count FROM cartitem WHERE Mastercart_id = '$mast'");
            $remaining_items = mysqli_fetch_assoc($remaining_items_query)['count'];

            if ($remaining_items == 0) {
              // If no remaining items, delete the cartmaster entry as well
              $delete_cartmaster_query = mysqli_query($conn, "DELETE FROM cartmaster WHERE Mastercart_id = '$mast'");
            }
          }
        endwhile;
