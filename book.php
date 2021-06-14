<?php
    function book($bookID, $bookImg, $bookName, $bookDesc, $bookAmt){
        $element = "
        <div class=\"col-md-3 col-sm-6 my-3 my-md-0\">
            <form action=\"welcome.php\" method =\"post\">
                <div class=\"book shadow\">
                    <div>
                        <img src=\"$bookImg\" alt=\"Image1\" class=\"img-fluid card-img-top\">
                    </div>
                    <div class=\"book body\">
                        <h5 class=\"book title\">$bookName</h5>
                            
                        <p class=\"book description\">
                            ID: $bookID Description: $bookDesc 
                        </p>

                        <p class=\"Amt\">
                            Amount: $bookAmt
                        </p>
                        <button type=\"submit\" class=\"btn btn-warning my-3\" name=\"add\">Add to Cart</button>
                        <input type='hidden' name='book_id' value='$bookID'>
                        
                    </div>
                </div>
            </form>
        </div>
        ";

        echo $element;
        //<input type='hidden' name='hold_amt' value=1>
    }
?>