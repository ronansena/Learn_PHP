<?php
$to = "seuemail@gmail.com";
$subject = "Oi Amigão!";
$body  = "<table width=100% border=0><tr><td>";
$body .= "<img width=200 src='";
$body .= "'></img></td><td style=position:absolute;left:350;top:60;><h2><font color = #346699>Gif Ltd.</font><h2></td></tr>";
$body .= '<tr><td colspan=2><br/><br/><br/><strong>Dear ,</strong></td></tr>';
$body .= '<tr><td colspan=2><br/><font size=3>As per Your request we send Your Password.</font><br/><br/>Password is : <b></b></td></tr>';
$body .= '<tr><td colspan=2><br/>If you have any questions, please feel free to contact us at:<br/><a href="mailto:support@gif.com" target="_blank">support@gif.com</a></td></tr>';
$body .= '<tr><td colspan=2><br/><br/>Best regards,<br>The Gif Team.</td></tr></table>';
$body .= '
<!-- START FOOTER -->
<div class="footer">
  <table
    role="presentation"
    border="0"
    cellpadding="0"
    cellspacing="0"
  >
    <tr>
      <td class="content-block">
        <span class="apple-link"
          >Company Inc, testes</span
        >
        <br />
        Dont like these emails?
        <a href="">Unsubscribe</a>.
      </td>
    </tr>
    <tr>
      <td class="content-block powered-by">
        Powered by <a href="">HTMLemail</a>.
      </td>
    </tr>
  </table>  
</div>';
$headers = "From: Jeniffer";
$headers .= "Reply-To:seuemail@gmail.com";
$headers .= "Return-Path: seuemail@gmail.com";
$headers .= "X-Mailer: PHP5n";
$headers .= "MIME-Version: 1.0\r\n";
//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "rn";

$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

if (mail($to, $subject, $body, $headers))
  echo "Your Mail is sent successfully.";
else
  echo "Your Mail is not sent. Try Again.";
