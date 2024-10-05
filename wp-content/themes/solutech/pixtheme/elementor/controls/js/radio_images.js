jQuery( window ).on( 'elementor:init', function() {
    var radioimagesControl = elementor.modules.controls.BaseData.extend({
        
        onReady: function () {
            
            this.radio_images_controls = this.$el.find('.pix-radio-images-field');
            var check_val = '';
            _.each( this.radio_images_controls, function(item) {
                if(item.checked) {
                    check_val = item.value;
                }
            });
            this.control_value = check_val;
            
            this.radio_images_controls.on('click', () => {
                _.each( this.radio_images_controls, function(item) {
                    if(item.checked) {
                        check_val = item.value;
                    }
                });
                this.control_value = check_val;
                this.saveValue();
            })
            
        },
        
        saveValue: function () {
            this.setValue(this.control_value);
        },
        
        onBeforeDestroy: function () {
            this.saveValue();
        }
    });
    
    elementor.addControlView('radio_images', radioimagesControl);
});