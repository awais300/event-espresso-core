<?php

/**
 * @type string $events_requiring_pre_approval
 * @type string $events_requiring_pre_approval_msg
 */

?>

<h4>
    <span class="orange-text">
        <?php esc_html_e('Important Notice: Events Requiring Pre-Approval', 'event_espresso'); ?>
    </span>
</h4>
<p id="events-requiring-pre-approval-pg" class="small-text drk-grey-text">
    <?php echo $events_requiring_pre_approval_msg; // already escaped ?>
</p>
<ul id="spco-pre-approval-events-ul">
    <?php echo $events_requiring_pre_approval; // already escaped ?>
</ul>
