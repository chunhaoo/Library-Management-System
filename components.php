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
    }

    function cartItems($bookID, $bookImg, $bookName, $bookDesc){
        $element = "
        <form action=\"cart.php?action=remove&id=$bookID\" method=\"post\" class=\"cart-items\">
                    <div class=\"border rounded\">
                        <div class=\"row bg-white\">
                            <div class=\"col-md-3\">
                                <img src=\"$bookImg\" alt=\"Image1\" class=\"img-fluid\">
                            </div>
                            <div class=\"col-md-5\">
                                <h5 class=\"pt-2\">$bookName</h5>
                                <small class=\"text-secondary\">$bookDesc</small>
                                <h5 class=\"pt-2\">$bookID</h5>
                            </div>
                            <div class=\"col-md-3 py-5\">
                                <button type=\"submit\" class=\"btn btn-danger mx-2\" name=\"remove\">Remove</button>
                            </div>
                        </div>
                    </div>
                </form>
        ";
        echo $element;
    }

?>
