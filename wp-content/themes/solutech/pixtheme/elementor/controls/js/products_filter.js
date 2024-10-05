jQuery( window ).on( 'elementor:init', function() {
    var productsfilterControl = elementor.modules.controls.BaseData.extend({
        
        pix_change_el_data: function(parent){
            var data = {},
                select = [],
                dataJSON = '';
            if( parent.getElementsByClassName('pix-widget-option').length ){
                _.each( parent.getElementsByClassName('pix-widget-option'), function(item) {
                    var row = '1';
                    row = item.querySelector('input[type=radio]:checked').value;
                    select.push({
                        id : item.dataset.field,
                        name : item.querySelector('input[type="text"]').value,
                        row : row,
                        show : item.querySelector('input[type="checkbox"]').checked
                    });
                });
            }
            dataJSON = JSON.stringify(select);
            this.input_control.value = dataJSON;
            //console.log(this.input_control.value);
            this.saveValue();
        },
        
        onReady: function () {
            var pix_this = this,
                filters = this.getControlValue();
            console.log(filters);
            this.sortable_control = this.$el.find('.pix-widget-sortable')[0];
            this.input_control = this.$el.find('.pix-input-el-filter')[0];
            this.input_control.value = filters;
            this.sortable = Sortable.create(this.sortable_control, {
                animation: 150,
                ghostClass: 'ui-state-highlight',
                onUpdate: function (evt) {
                    pix_this.pix_change_el_data(evt.item.parentElement);
                },
            });
    
            const inputEl = this.sortable_control.querySelectorAll('input');
            _.each( inputEl, function(item) {
                item.addEventListener('change', (event) => {
                    pix_this.pix_change_el_data(item.closest('.pix-widget-sortable'));
                });
            });
            
        },
        
        saveValue: function () {
            this.setValue(this.input_control.value);
        },
        
        onBeforeDestroy: function () {
            this.saveValue();
        },
        
    });
    
    elementor.addControlView('products_filter', productsfilterControl);
});