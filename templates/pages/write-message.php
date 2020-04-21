<?php
/**
 * @var \lib\service\MessageFormValidation $validation
 */
?>


<form method="post">
    <h2 class="is-size-3">Write a new message:</h2>

    <div class="field">
        <label class="label" for="field-recipient">Recipient</label>
        <div class="control">
            <input id="field-recipient" name="recipient" class="input" type="text" placeholder="The username of the recipient">
        </div>
        <?php if ($validation->getRecipientErr()): ?>
            <p class="help is-danger"><?= htmlspecialchars($validation->getRecipientErr()) ?></p>
        <?php endif; ?>
    </div>

    <div class="field">
        <label class="label" for="field-title">Title / Subject</label>
        <div class="control">
            <input type="text" name="title" id="field-title" class="input" required maxlength="255">
        </div>
    </div>

    <div class="field">
        <label class="label" for="message-body">The message</label>
        <div class="control">
            <textarea id="message-body" name="message-body" class="textarea" rows="9" required></textarea>
        </div>
    </div>


    <div class="field">
        <div class="control">
            <button type="submit" name="submit" class="button is-fullwidth is-link">
                Submit
            </button>
        </div>
    </div>
</form>
