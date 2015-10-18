<?php
/**
 * Sample PHP code to use reCAPTCHA V2.
 *
 * @copyright Copyright (c) 2014, Google Inc.
 * @link      http://www.google.com/recaptcha
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
require_once "templates/recaptchalib.php";
// Register API keys at https://www.google.com/recaptcha/admin
$siteKey = "6LeM-QATAAAAAEIF6zwvdCtrgqazgWCpp_1VowPy";
$secret = "6LeM-QATAAAAAM6o3J6IuLy_FkCNvomMITycE1n9";
// reCAPTCHA supported 40+ languages listed here: https://developers.google.com/recaptcha/docs/language
$lang = "ru";
// The response from reCAPTCHA
$resp = null;
// The error code from reCAPTCHA, if any
$error = null;
$reCaptcha = new ReCaptcha($secret);
// Was there a reCAPTCHA response?
if ($_POST["g-recaptcha-response"]) {
    $resp = $reCaptcha->verifyResponse(
            $_SERVER["REMOTE_ADDR"], $_POST["g-recaptcha-response"]
    );
}
?>
<script type="text/javascript" src="/bcms/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
    tinymce.init({
        selector: "textarea",
        theme: "modern",
        skin: 'light',
        menubar: false,
        statusbar: false,
        height: 150,
        autosave_interval: "20s",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak autosave",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor responsivefilemanager"
        ],
        toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
        image_advtab: true,
        language: 'ru',
        external_filemanager_path: "../../../bcms/filemanager/",
        filemanager_title: "Responsive Filemanager",
        browser_spellcheck: true,
        external_plugins: {"filemanager": "../../../bcms/filemanager/plugin.min.js"}
    });
</script>

<link href="templates/<?= $settings['template'] ?>/css/style.css" rel="stylesheet">

<style type="text/css">
    label {
        display:inline-block;
        font-size:14px;
        width: 110px;
    }
    form#contactform input[type="text"] {
        border-color:#B7B7B7 #E8E8E8 #E8E8E8 #B7B7B7;
        border-style:solid;
        border-width:1px;
        padding:5px;
        font-size:15px;
        width: 75%;
        margin: 4px 0px 4px 0px;
    }
    #contact-wrapper {
        width:100%;
        padding-left:1%;
    }
    .knopka{
        font-size:15px;
        cursor:pointer;
    }
</style>
</head>

<body>
    <?php // echo "<pre>"; echo print_r($error); echo "</pre>";?>
    <div id="contact-wrapper">

        <?php if ($_POST['name'] != "" and $_POST['email'] != "" and $_POST['subject'] != "" and $_POST['text'] != "") { //Если не найдены ошибки   ?>
            <p class="success">Сообщение отправлено.</p>
        <?php } ?>

        <?php if ($_POST['name'] == "" and $_POST['email'] == "" and $_POST['subject'] == "" and $_POST['text'] == "" and isset($_POST['submit'])) { //Если найдены ошибки   ?>
            <p class="success">Сообщение не отправлено. Заполните все поля.</p>
        <?php } ?>

        <form method="post" action="#" id="contactform">
            <p>
                <label for="name"><strong>Имя:</strong></label>
                <input type="text" size="50" name="name" id="name" value="" class="required" />
            </p>

            <p>
                <label for="email"><strong>Email:</strong></label>
                <input type="text" size="50" name="email" id="email" value="" class="required email" />
            </p>

            <p>
                <label for="subject"><strong>Тема:</strong></label>
                <input type="text" size="50" name="subject" id="subject" value="" class="required" />
            </p>	
            <p>
                <label for="message" style="display:block; font-size:14px; margin-left:2px;"><strong>Сообщение:</strong></label>
            </p>
            <!-- form begin --> 
            <div id="post" >
                <textarea id="text" name="text"><?php if (isset($_POST['text'])) echo $_POST['text'] ?></textarea>
                <p style="margin: 6px 0px 2px 0px;"><div align="center" class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div></p>
                <p align="center"  style="margin: 6px 0px 2px 0px;"><input type="submit" class="knopka" value="Отправить сообщение" name="submit" /></p>
                <script type="text/javascript"
                        src="https://www.google.com/recaptcha/api.js?hl=<?php echo $lang; ?>">
                </script>
        </form>
    </div>
</div>