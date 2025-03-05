jQuery(".my-map").hover(
    function(e) {
        const modal = jQuery("#modal");
        const title = jQuery(this).data("modal-content");
        const id = jQuery(this).data("modal-id");
        modal.children(".modal-title").text(title);
        modal.children(".modal-id").text(id);
        modal.css({
            display: "flex",
            left: e.pageX + 10, // Adjust as needed
            top: e.pageY - 10, // Adjust as needed
        });
        // modal.children("modal-content").text(getXml(id));
        jQuery(".modal-content").empty();
        getXml(id);

    },
    function() {
        jQuery("#modal").css("display", "none");
    }
);

function getXml(id) {
    console.log(id);
    jQuery.ajax({
        url: " ./map.xml",
        dataType: "xml",
        success: function(data) {
            var content = $(data).find(id).text().trim();
            // console.log(content);
            // jQuery(".modal-content").text(content);

            var lines = content.split('\n'); // 将内容分割成行

            // 遍历每一行数据，为每行创建一个 <div> 元素并添加到 .modal-content
            lines.forEach(function(line) {
                var div = $('<div>' + line + '</div>'); // 创建 <div> 元素
                jQuery(".modal-content").append(div); // 添加到 .modal-content
            });
        },
        error: function() {
            console.log("error");
        },
    });
}