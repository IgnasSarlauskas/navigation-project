
<form <?php print html_attr(($form['attr'] ?? []) + ['method' => 'POST']); ?>> 
    
    <!-- Input Field Generation  -->
    <?php foreach ($form['fields'] ?? [] as $field_id => $field): ?>
        <!-- Check if field array has 'label' and print it in case it is true  -->
        <?php if (isset($field['label'])) : ?>
            <label>
                <?php print $field['label']; ?>
        <?php endif; ?>
                <!--printing inputs with their attributes from form array-->
                <input <?php print html_attr(['type' => $field['type'], 'name' => $field_id, 'placeholder' => $field['placeholder']]); ?>>
                <!-- Check For Errors  -->
                <p class="color-red"><?php print $field['error'] ?? ''; ?></p>
        <!-- check if label is set-->
        <?php if (isset($field['label'])) : ?>
            </label>
        <?php endif; ?>
        <!--end label check-->
    <?php endforeach; ?>
        
    <!-- Button Field Generation  -->
    <?php foreach ($form['buttons'] ?? [] as $button_id => $button): ?>
        <button <?php print html_attr($button); ?>> <?php print $button_id; ?> </button>
    <?php endforeach; ?>

    <!--If field array has message key then print the message-->
    <?php foreach ($form['message'] ?? [] as $value): ?>
        <?php if (isset($value)) : ?>
            <p class="color-red"><?php print $value; ?></p>
        <?php endif; ?> 
    <?php endforeach; ?>
</form>

