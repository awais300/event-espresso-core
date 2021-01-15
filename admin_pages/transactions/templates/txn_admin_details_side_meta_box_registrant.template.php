<?php
/**
 * @var int    $ATT_ID
 * @var string $no_attendee_message
 * @var string $prime_reg_fname
 * @var string $prime_reg_lname
 * @var string $prime_reg_email
 * @var string $prime_reg_phone
 * @var string $formatted_address
 * @var string $edit_attendee_url
 */

?>
<div id="admin-side-mbox-primary-registrant-dv" class="admin-side-mbox-dv">
<?php if (! empty($no_attendee_message)) : ?>
    <p class="clearfix">
        <?php echo $no_attendee_message; ?>
    </p>
<?php else : ?>
    <p class="clearfix">
        <span class="admin-side-mbox-label-spn lt-grey-txt float-left">
            <?php esc_html_e('Name', 'event_espresso'); ?>
        </span>
        <?php echo $prime_reg_fname . ' ' . $prime_reg_lname; ?>
    </p>
    <p class="clearfix">
        <span class="admin-side-mbox-label-spn lt-grey-txt float-left">
            <?php esc_html_e('Email', 'event_espresso'); ?>
        </span>
        <a href="mailto:<?php echo $prime_reg_email; ?>"><?php echo $prime_reg_email; ?></a>
    </p>
    <p class="clearfix">
        <span class="admin-side-mbox-label-spn lt-grey-txt float-left">
            <?php esc_html_e('Phone #', 'event_espresso'); ?>
        </span>
        <?php if (! empty($prime_reg_phone)) : ?>
            <a href="tel:<?php echo $prime_reg_phone; ?>">
                <?php echo $prime_reg_phone; ?>
            </a>
        <?php endif; ?>
    </p>
    <p class="clearfix">
        <span class="admin-side-mbox-label-spn lt-grey-txt float-left">
            <?php esc_html_e('Address', 'event_espresso'); ?>
        </span>
    </p>
    <div class="admin-side-mbox-text-dv">
        <?php echo $formatted_address; ?>
    </div>
</div> <!-- end #admin-side-mbox-primary-registrant-dv -->

    <?php
    /** only show if logged in user has access */
    if (EE_Registry::instance()->CAP->current_user_can(
        'ee_edit_contact',
        'view_or_edit_contact_button',
        $ATT_ID
    )
    ) : ?>
        <p style="text-align:right;">
            <a class="button button-small" href="<?php echo $edit_attendee_url; ?>"
               title="<?php esc_attr_e('View details for this contact.', 'event_espresso'); ?>">
                <span class="ee-icon ee-icon-user-edit"></span>
                <?php esc_html_e(
                    'View / Edit this Contact',
                    'event_espresso'
                ); ?>
            </a>
        </p>
    <?php endif;
endif;
