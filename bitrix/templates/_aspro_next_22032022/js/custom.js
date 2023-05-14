/*
You can use this file with your scripts.
It will not be overwritten when you upgrade solution.
*/
$(function() {
    //Показать/Скрыть разделы в производителях
    const showSections = document.querySelector("#show-sections-manufact");
    const hiddenSectionsBlock = document.querySelector("#hidden-sections");
    const showTmarks = document.querySelector("#show-tmarks");

    if(showSections){
        showSections.addEventListener("click", e=>{
            e.preventDefault();
            console.log( hiddenSectionsBlock )
            hiddenSectionsBlock.classList.toggle("hidden-sections-manufact");
            showSections.remove();
        });
    }



    if(showTmarks){
        showTmarks.addEventListener("click", e=>{
            e.preventDefault();
            const hiddenTmarks = document.querySelectorAll(".hidden-tmarks");
            const tmarkaRow = document.querySelector("#tmarka-row");

            showTmarks.remove();

            hiddenTmarks.forEach(item => {
                item.classList.toggle("hidden-tmarks")
                tmarkaRow.appendChild( item );
            });


        });
    }



});