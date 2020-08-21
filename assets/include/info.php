<div id="scanned_item_info">
    <h3>Scanned Item Info:</h3>
    <table id="scanned_item_info_table">
        <tr>
            <td><b>Item Type:</b></td>
            <td id="item_info_type"></td>
        </tr>
        <tr>
            <td><b>Name:</b></td>
            <td id="item_info_name"></td>
        </tr>
        <tr>
            <td><b>UID:</b></td>
            <td id="item_info_uid"></td>
        </tr>
        <tr>
            <td><b>Current Rack Location:</b></td>
            <td id="item_info_location"></td>
        </tr>
    </table>
</div>

<script>
    const itemInfoType = document.getElementById('item_info_type');
    const itemInfoName = document.getElementById('item_info_name');
    const itemInfoUID = document.getElementById('item_info_uid');
    const itemInfoLocation = document.getElementById('item_info_location');

    <?php

    // getPassedArray(): Void -> Array
    // Returns which of {$rm_info, $dispersion_info} is nonempty
    function getPassedArray()
    {
        global $rm_info, $dispersion_info;

        if (!empty($rm_info)) {
            return $rm_info;
        } else {
            return $dispersion_info;
        }
    }

    // returnItemType(): Void -> String
    // Returns the item type of the scanned item
    function returnItemType()
    {
        global $rm_info, $dispersion_info;

        if (!empty($rm_info)) {
            return 'Raw Material';
        } else if (!empty($dispersion_info)) {
            return 'Dispersion';
        } else {
            return 'Unrecognized';
        }
    }

    $passed_array = getPassedArray();
    $item_type = returnItemType();
    $item_name = $passed_array['name'];
    $item_uid = $passed_array['uid'];
    $item_location = $passed_array['location'];
    ?>

    itemInfoType.innerText = '<?php echo $item_type ?>';
    itemInfoName.innerText = '<?php echo $item_name ?>';
    itemInfoUID.innerText = '<?php echo $item_uid ?>';
    itemInfoLocation.innerText = '<?php echo $item_location ?>';
</script>