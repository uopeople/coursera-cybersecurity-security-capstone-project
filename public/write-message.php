<?php

include __DIR__ . '/../setup.php';

?>
<body>
<div class="container main">
    <h1>Write a new message:</h1>

    <hr>

    <form method="post" action="write-message-post.php">
        <div>
            <label>
                <span>Recipient</span><br>
                <input type="text" name="recipient" required>
            </label>
        </div>
        <div>
            <label>
                <span>Title / Subject</span><br>
                <input type="text" name="title" required>
            </label>
        </div>
        <div>
            <label for="message-body">
                The message:
            </label>
            <textarea id="message-body" name="message-body"></textarea>
        </div>

        <div>
            <button type="submit" name="submit">Submit</button>
        </div>
    </form>
</div>
</body>
