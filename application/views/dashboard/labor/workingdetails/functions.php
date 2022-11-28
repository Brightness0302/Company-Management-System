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
        
    })

    $("#invoicetable tbody tr td select").change(async function() {
    })
    
});

async function saveWorkdetails() {
    const etr = $(this).closest('tr');
    const eproject = etr.find("select");
    if (eproject.length === 0)
        return;
    const edate = etr.find("td")[0];
    const employee_id = "<?=$employee['id']?>";
    const employee_type = "<?=$employee['type']?>";
    if (!eproject.length)
        return;
    const detail_date = strtodate($(edate).find("label")[1]);
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
}

async function getWorkdetails() {
    const etr = $(this).closest('tr');
    const eproject = this.value;
    const edate = etr.find("td")[0];
    const detail_date = strtodate($(edate).find("label")[1]);
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
}

function strtodate(detail_date_str_ISO) {
    const detail_date_str_list = ($(detail_date_str_ISO).text()).split("/");
    const detail_date = detail_date_str_list[2]+'/'+detail_date_str_list[0]+'/'+detail_date_str_list[1];
    return detail_date;
}
function refreshTableData() {
    const projects_length = Number("<?=count($projects)?>");
    const etable = $("#invoicetable tbody");
    const employee_id = "<?=$employee['id']?>";
    const employee_type = "<?=$employee['type']?>";
    const searchtag = $("#searchtag").val();
    $(etable).children("tr").each(async(index, ele1) => {
        try {
            const etr = $(ele1).find("td");
            const etextarea = $(etr[2]).find("textarea");
            const eselect = $(etr[1]).find("select");
            const detail_date = strtodate($(etr[0]).find("label")[1]);
            if (eselect.length === 0) 
                return;
            $($(eselect[0].options).get().reverse()).each(async(index, ele2) => {
                if (($(ele2)[0].text).includes(searchtag) || !searchtag)
                    return;
                const form_data = { 
                    employee_id: employee_id, 
                    employee_type: employee_type, 
                    project_id: $(ele2)[0].value, 
                    detail_date: detail_date,
                };
                const details = await getData(form_data);
                console.log(detail_date, $(ele2)[0].value, details, searchtag);
                if (!(details.includes(searchtag)) || !details) {
                    if (eselect[0].options.length === 1)
                        $(eselect[0]).empty();
                    else
                        eselect[0].remove(projects_length - 1 - index);
                }
            }).promise().done(async() => {
                if (!eselect[0].value)
                    return;
                const form_data = {
                    employee_id: employee_id, 
                    employee_type: employee_type, 
                    project_id: eselect[0].value, 
                    detail_date: detail_date,
                };
                const details = await getData(form_data);
                $(etextarea[0]).val(details);
                etextarea[0].dispatchEvent(new Event('input', {bubbles:true}));
            })
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