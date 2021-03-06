<table id="item_info_table">
    <caption>Item Info</caption>
    <thead>
        <tr>
            <th scope="col">Item Type</th>
            <th scope="col">Name</th>
            <th scope="col">UID</th>
            <th scope="col">Period</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td data-label="Item Type" id="item_info_type"></td>
            <td data-label="Name" id="item_info_name"></td>
            <td data-label="UID" id="item_info_uid"></td>
            <td data-label="Quantity (Kg)" id="item_info_quantitykg"></td>
            <td data-label="Expiration Date" id="item_info_expdate"></td>
            <td data-label="Rack Location" id="item_info_rackloc"></td>
            <td data-label="LOT" id="item_info_lot"></td>
            <td data-label="RM #" id="item_info_rm"></td>
            <td data-label="Owner" id="item_info_owner"></td>
            <td data-label="EXP" id="item_info_exp"></td>
            <td data-label="CS" id="item_info_cs"></td>
            <td data-label="ECT" id="item_info_ect"></td>
            <td data-label="Container" id="item_info_container"></td>
            <td data-label="Notes" id="item_info_notes"></td>
        </tr>
    </tbody>
</table>

<?php
$item_type = getFullItemType();
$item_name = $passed_array['name'];
$item_uid = $passed_array['uid'];
$item_quantitykg = $passed_array['quantity_Kg'];
$item_expdate = $passed_array['Exp_Date'];
$item_rackloc = $passed_array['location'];
$item_lot = $passed_array['LOT'];
$item_rm = $passed_array['RM'];
$item_you = $passed_array['YOU'];
$item_ben = $passed_array['BEN'];
$item_exp = $passed_array['EXP'];
$item_cs = $passed_array['CS'];
$item_ect = $passed_array['ECT'];
$item_container = $passed_array['container'];
$item_notes = $passed_array['notes'];
?>

<script>
    // Sets all item info
    const infoType = document.getElementById('item_info_type');
    const infoName = document.getElementById('item_info_name');
    const infoUID = document.getElementById('item_info_uid');
    const infoQuantityKg = document.getElementById('item_info_quantitykg');
    const infoExpDate = document.getElementById('item_info_expdate');
    const infoRackLoc = document.getElementById('item_info_rackloc');
    const infoLot = document.getElementById('item_info_lot');
    const infoRM = document.getElementById('item_info_rm');

    // These might be empty
    const infoOwner = document.getElementById('item_info_owner');
    const infoEXP = document.getElementById('item_info_exp');
    const infoCS = document.getElementById('item_info_cs');
    const infoECT = document.getElementById('item_info_ect');
    const infoContainer = document.getElementById('item_info_container');
    const infoNotes = document.getElementById('item_info_notes');

    infoType.innerText = '<?php echo $item_type ?>';
    infoName.innerText = '<?php echo $item_name ?>';
    infoUID.innerText = '<?php echo $item_uid ?>';
    infoQuantityKg.innerText = '<?php echo $item_quantitykg ?>';
    infoExpDate.innerText = '<?php echo $item_expdate ?>';
    infoRackLoc.innerText = '<?php echo $item_rackloc ?>';
    infoLot.innerText = '<?php echo $item_lot ?>';
    infoRM.innerText = '<?php echo $item_rm ?>';

    // Sets Owner value in table
    <?php
    $item_owner;
    if ($item_you == 1) {
        $item_owner = "Younique";
    } else if ($item_ben == 1) {
        $item_owner = "Bentley Labs";
    } else {
        $item_owner = "LEI";
    }
    ?>

    infoOwner.innerText = '<?php echo $item_owner ?>';

    // Might be empty
    infoEXP.innerText = '<?php echo $item_exp ?>';
    infoCS.innerText = '<?php echo $item_cs ?>';
    infoECT.innerText = '<?php echo $item_ect ?>';
    infoContainer.innerText = '<?php echo $item_container ?>';
    infoNotes.innerText = '<?php echo $item_notes ?>';


    // hideIfEmpty(): DOM Element -> Void
    // hides an element if its contents are empty
    function hideIfEmpty(el) {
        if (el.innerText === '') {
            el.style.display = "none";
        }
    }

    // hides non-critical empty fields
    hideIfEmpty(infoECT);
    hideIfEmpty(infoContainer);
    hideIfEmpty(infoNotes);
</script>