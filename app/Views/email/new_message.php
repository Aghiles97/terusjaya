<?= view('email/_header', ['title' => trans("you_have_new_message")]); ?>
<?php $emailData = unserializeData($emailRow->email_data); ?>
<table role="presentation" class="main">
    <tr>
        <td class="wrapper">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <h1 style="text-decoration: none; font-size: 20px;line-height: 28px;font-weight: bold;margin-bottom: 5px;"><?= $subject; ?></h1>
                        <div class="mailcontent" style="line-height: 26px;font-size: 14px;">
                            <p style='text-align: left;margin-bottom: 10px;'>
                                <strong style="font-weight: 600;"><?= trans("user"); ?></strong>:&nbsp;<?= !empty($emailData['messageSender']) ? esc($emailData['messageSender']) : ''; ?>
                            </p>
                            <p style='text-align: left;margin-bottom: 10px;'>
                                <strong style="font-weight: 600;"><?= trans("subject"); ?></strong>:&nbsp;<?= !empty($emailData['messageSubject']) ? esc($emailData['messageSubject']) : ''; ?>
                            </p>
                            <p style='text-align: left;margin-bottom: 10px;'>
                                <strong style="font-weight: 600;"><?= trans("message"); ?></strong>:<br><?= !empty($emailData['messageText']) ? esc($emailData['messageText']) : ''; ?>
                            </p>
                        </div>
                        <p style='text-align: center;margin-top: 60px;'>
                            <a href='<?= generateUrl("messages"); ?>'
                               style="font-size: 15px;
                                       text-decoration: none;
                                       padding: 10px 32px;
                                       background-color: <?= $generalSettings->site_color; ?>;
                                       color: #ffffff !important;
                                       border-radius: 3px;
                                       display: inline-block;
                                       white-space: nowrap;
                                       mso-padding-alt: 0;
                                       border: 1px solid <?= $generalSettings->site_color; ?>;">
                                <?= trans("messages"); ?>
                            </a>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?= view('email/_footer'); ?>
