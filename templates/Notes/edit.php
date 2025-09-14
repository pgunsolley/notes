<?= $this->element('CrudView.form') ?>

<script>
    $(document).ready(function() {
        const bodyInput = $('#body');
        const bodyInputValueLength = bodyInput.val().length;
        bodyInput[0].focus();
        bodyInput[0].setSelectionRange(bodyInputValueLength, bodyInputValueLength);
    });
</script>