<script type="text/javascript">
var daysperyear = 218;
var count_month = 12;
$(document).ready(function() {
    $("input").change(function() {
        const id = this.id;
        if (id == "salary" || id == "tax") {
            refreshAmount();
        }
    });
    $("#coin").change(function() {
        const els = $(".coin");
        els.each((index, element) => {
            $(element).text(this.value);
        });
    });
    refreshAmount();

    $("#invoicetable tbody tr td textarea").change(async function() {
        const etr = $(this).closest('tr');
        const eproject = etr.find("select");
        const edate = etr.find("td")[0];
        const employee_id = "<?=$employee['id']?>";
        const employee_type = "<?=$employee['type']?>";
        if (!eproject.length)
            return;
        const detail_date = $(edate).text().split(" ")[1];
        const form_data = {
            employee_id: employee_id, 
            employee_type: employee_type, 
            project_id: eproject[0].value, 
            detail_date: detail_date,
            work_details: this.value, 
        };
        await $.ajax({
            url: "<?=base_url('labor/saveworkdetails')?>",
            method: "POST",
            data: form_data, 
            dataType: 'json',
            success: function(res) {
                if (res < 1) {
                    alert("Server Error");
                }
            }, 
            error: function (a, b) {
                console.log(a, b);
                alert("Server Error");
            }
        });
    })

    $("#invoicetable tbody tr td select").change(async function() {
        const etr = $(this).closest('tr');
        const eproject = this.value;
        const edate = etr.find("td")[0];
        const detail_date = $(edate).text().split(" ")[1];
        const etextarea = etr.find("textarea");
        const employee_id = "<?=$employee['id']?>";
        const employee_type = "<?=$employee['type']?>";
        const form_data = {
            employee_id: employee_id, 
            employee_type: employee_type, 
            project_id: eproject, 
            detail_date: detail_date,
        };
        const details = await getData(form_data);
        $(etextarea[0]).val(details);
        etextarea[0].dispatchEvent(new Event('input', {bubbles:true}));
    })
    
});
function refreshTableData() {
    const etable = $("#invoicetable tbody");
    const employee_id = "<?=$employee['id']?>";
    const employee_type = "<?=$employee['type']?>";
    $(etable).children("tr").each(async(index, element) => {
        try {
            const etr = $(element).find("td");
            const etextarea = $(etr[2]).find("textarea");
            const eselect = $(etr[1]).find("select");
            const detail_date = $(etr[0]).text().split(" ")[1];
            const form_data = {
                employee_id: employee_id, 
                employee_type: employee_type, 
                project_id: eselect[0].value, 
                detail_date: detail_date,
            };
            // console.log(form_data);
            const details = await getData(form_data);
            $(etextarea[0]).val(details);
            etextarea[0].dispatchEvent(new Event('input', {bubbles:true}));
        }
        catch(err) {
            console.log(err);
        }
    });
}

async function getData(form_data) {
    return $.ajax({
        url: "<?=base_url('labor/getworkdetailsbydate')?>",
        method: "POST",
        data: form_data, 
        dataType: 'text',
    });
}

function refreshAmount() {
    const salary = $("#salary").val();
    const tax = $("#tax").val();
    
    if (salary && tax) {
        $("#total").val((parseFloat(salary)+parseFloat(tax)).toFixed(2));
        $("#daily").val(((parseFloat(salary)+parseFloat(tax))*count_month/daysperyear).toFixed(2));
    }
}
</script>