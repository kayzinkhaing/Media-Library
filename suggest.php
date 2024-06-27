<?php 
//Import the PHPMailer class into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require 'vendor/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/src/Exception.php';
require 'vendor/phpmailer/src/SMTP.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    //retrieving datas without repetitively
    $name=trim(filter_input(INPUT_POST,"name",FILTER_SANITIZE_STRING));
    $email=trim(filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL));
    $category=trim(filter_input(INPUT_POST,"category",FILTER_SANITIZE_STRING));
    $title=trim(filter_input(INPUT_POST,"title",FILTER_SANITIZE_STRING));
    $format=trim(filter_input(INPUT_POST,"format",FILTER_SANITIZE_STRING));
    $genre=trim(filter_input(INPUT_POST,"genre",FILTER_SANITIZE_STRING));
    $year=trim(filter_input(INPUT_POST,"year",FILTER_SANITIZE_NUMBER_INT));
    $details=trim(filter_input(INPUT_POST,"details",FILTER_SANITIZE_SPECIAL_CHARS));

    if ($name == "" || $email == "" || $category == "" || $title == "" || $details=="") {
        $error_message = "Please Fill in the required field: Name, Email, Category,Title and Details";
        
    }
    if (!isset($error_message) && $_POST["address"] != "") {
        $error_message = "Bad form input";
    }
    if(!isset($error_message) && !PHPMailer::validateAddress($email)) {
        $error_message = "Invalid Email Address";
    }
    if(!isset($error_message)) {

        $email_body = "";
        $email_body .= "Name " . $name ."\n";
        $email_body .= "Email " . $email ."\n";
        $email_body .= "\n\nSuggest Item\n\n";
        $email_body .= "Category " . $category ."\n";
        $email_body .= "Title " . $title ."\n";
        $email_body .= "Format " . $format ."\n";
        $email_body .= "Genre " . $genre ."\n";
        $email_body .= "Year " . $year ."\n";
        $email_body .= "Details " . $details ."\n";
    
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = 2;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = 'kayzinkhaing1331@gmail.com';
        $mail->Password = 'fjao fval immz iylg';

        $mail->setFrom('kayzinkhaing1331@gmail.com', $name);
        $mail->addReplyTo($email, $name);
        $mail->addAddress('kayzinkhaing1331@gmail.com','Kay Zin Khaing');
        $mail->Subject = 'Library suggest from ' . $name;
        $mail->Body = $email_body ;
        if ($mail->send()) {    // -> single arrow operator is object operator that can use for access/call methods and properties
            header("location:suggest.php?status=thanks");
            exit;
        } 
        $error_message = "Mailer Error: ". $mail->ErrorInfo;
    }
}

$pageTitle= "Suggest a Media Item";
$section="suggest";

include("inc/header.php"); 
?>

<div class="section page">
    <div class="wrapper">
        <h1>Suggest a Media Item</h1>
        <?php if (isset($_GET["status"]) && $_GET["status"] == "thanks") {
            echo " <p>Thanks for the email! I&rsquo;ll check out your suggestion shortly!</p>";
        } else { 
            if (isset($error_message)){
                echo "<p class='message'>". $error_message . "</p>";
            }else {
                echo "If you think is something I&rsquo;m missing, Let me know! Complete the form to send me an email.";
            } 
        ?>
        <form method="post" action="suggest.php">
            <table>
                <tr>
                    <th><label for="name">Name (required)</label></th>
                    <td><input type="text" id="name" name="name" /></td>
                </tr>
                <tr>
                    <th><label for="email">Email (required)</label></th>
                    <td><input type="text" id="email" name="email" /></td>
                </tr>
                <tr>
                    <th><label for="category">Category (required)</label></th>
                    <td><select id="category" name="category" >
                        <option value=" ">Select One</option>
                        <option value="Books" <?php if (isset($category) && $category == "Books") echo "selected";?>>Book</option>
                        <option value="Movies" <?php if (isset($category) && $category == "Movies") echo "selected";?>>Movie</option>
                        <option value="Music" <?php if (isset($category) && $category == "Books") echo "selected";?>>Music</option>
                        </select></td>
                </tr>
                <tr>
                    <th><label for="title">Title (required)</label></th>
                    <td><input type="text" id="title" name="title" value="<?php if (isset($title)) { echo $title; }?>" /></td>
                </tr>
                <tr>
                    <th>
                        <label for="format">Format</label>
                    </th>
                    <td>
                        <select id="format" name="format" >
                            <option value=" ">Select One</option>
                            <optgroup label="Books">
                                <option value="Audio"<?php if (isset($format) && $format=="Audio"){
                                    echo " selected"; 
                                } ?>>Audio</option>
                                <option value="Ebook"<?php if (isset($format) && $format=="Ebook"){
                                    echo " selected"; 
                                } ?>>Ebook</option>
                                <option value="Hardback"<?php if (isset($format) && $format=="Hardback"){
                                    echo " selected"; 
                                } ?>>Hardback</option>
                                <option value="Paperback"<?php if (isset($format) && $format=="Paperback"){
                                    echo " selected"; 
                                } ?>>Paperback</option>
                        </optgroup>
                        <optgroup label="Movies">
                            <option value="Blu-ray"<?php if (isset($format) && $format=="Blu_ray"){
                                    echo " selected"; 
                                } ?>>Blu-ray</option>
                            <option value="DVD"<?php if (isset($format) && $format=="DVD"){
                                    echo " selected"; 
                                } ?>>DVD</option>
                            <option value="Streaming"<?php if (isset($format) && $format=="Streaming"){
                                    echo " selected"; 
                                } ?>>Streaming</option>
                            <option value="VHS"<?php if (isset($format) && $format=="VHS"){
                                    echo " selected"; 
                                } ?>>VHS</option>
                        </optgroup>
                        <optgroup label="Music">
                            <option value="Cassette"<?php if (isset($format) && $format=="Cassette"){
                                    echo " selected"; 
                                } ?>>Cassette</option>
                            <option value="CD"<?php if (isset($format) && $format=="CD"){
                                    echo " selected"; 
                                } ?>>CD</option>
                            <option value="MP3"<?php if (isset($format) && $format=="MP3"){
                                    echo " selected"; 
                                } ?>>MP3</option>
                            <option value="Vinyl"<?php if (isset($format) && $format=="Vinyl"){
                                    echo " selected"; 
                                } ?>>Vinyl</option>
                        </optgroup>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th><label for="genre">Genre</label>
                    </th>
                    <td>
                        <select name="genre" id="genre">
                            <option value="">Select One</option>
                            <optgroup label="Books">
                                    <option value="Action">Action</option>
                                    <option value="Advanture">Advanture</option>
                                    <option value="Comedy">Comedy</option>
                                    <option value="Fantasy">Fantasy</option>
                                    <option value="Historical">Historical</option>
                                    <option value="Historical Fiction">Historical Fiction</option>
                                    <option value="Horror">Horror</option>
                                    <option value="Magical Realism">Magical Realism</option>
                                    <option value="Mystery">Mystery</option>
                                    <option value="Paranoid">Paranoid</option>
                                    <option value="Philosophical">Philosophical</option>
                                    <option value="Political">Political</option>
                                    <option value="Romance">Romance</option>
                                    <option value="Saga">Saga</option>
                                    <option value="Satire">Satire</option>
                                    <option value="Sci-Fi">Sci-Fi</option>
                                    <option value="Tech">Tech</option>
                                    <option value="Thriller">Thriller</option>
                                    <option value="Urban">Urban</option>
            				</optgroup>
            				<optgroup label="Movies"> 
                            <option value="Action">Action</option>
                                    <option value="Adventure">Adventure</option>
                                    <option value="Animation">Animation</option>
                                    <option value="Biography">Biography</option>
                                    <option value="Comedy">Comedy</option>
                                    <option value="Crime">Crime</option>
                                    <option value="Documentary">Documentary</option>
                                    <option value="Drama">Drama</option>
                                    <option value="Family">Family</option>
                                    <option value="Fantasy">Fantasy</option>
                                    <option value="Film-Noir">Film-Noir</option>
                                    <option value="History">History</option>
                                    <option value="Horror">Horror</option>
                                    <option value="Musical">Musical</option>
                                    <option value="Mystery">Mystery</option>
                                    <option value="Romance">Romance</option>
                                    <option value="Sci-Fi">Sci-Fi</option>
                                    <option value="Sport">Sport</option>
                                    <option value="Thriller">Thriller</option>
                                    <option value="War">War</option>
                                    <option value="Western">Western</option>
            				</optgroup>
            				<optgroup label="Music">			
                            <option value="Blues">Blues</option>
                                    <option value="Classical">Classical</option>
                                    <option value="Country">Country</option>
                                    <option value="Dance">Dance</option>
                                    <option value="Easy Listening">Easy Listening</option>
                                    <option value="Electronic">Electronic</option>
                                    <option value="Folk">Folk</option>
                                    <option value="Hip Hop/Rap">Hip Hop/Rap</option>
                                    <option value="Inspirational/Gospel">Inspirational/Gospel</option>
                                    <option value="Jazz">Jazz</option>
                                    <option value="Latin">Latin</option>
                                    <option value="New Age">New Age</option>
                                    <option value="Opera">Opera</option>
                                    <option value="Pop">Pop</option>
                                    <option value="R&B/Soul">R&amp;B/Soul</option>
                                    <option value="Reggae">Reggae</option>
                                    <option value="Rock">Rock</option>
                                </optgroup>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="year">Year</label></th>
                    <td><input type="text" id="year" name="year" value="<?php 
                    if (isset($year)) echo $year;
                    ?>" /></td>
                </tr>
                <tr>
                    <th><label for="name">Suggest Item Details </label></th>
                    <td><textarea name="details" id="details"><?php 
                    if (isset($details))  echo $_POST["details"];
                    ?></textarea></td>
                </tr>
                <tr style="display:none">
                <th><label for = "address">Address</label></th>
                <td><input type="address" id="address" name="address" /></td>
                </tr>
                </table>
                <input class = "sendBtn" type="submit" value="Send" />

            </form>
        <?php } ?>
    </div>
</div>    


