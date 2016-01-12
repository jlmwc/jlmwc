// _forms.js
//  object containing form handling methods


PF.forms = {
    
    // creates a filter form based on an array of properties
    addForm: function (propertyList) {
        var features = featureLayer.getGeoJSON().features;
        for (var i = 0; i < propertyList.length; i++) {
            var values = PF.filter.makeList(features, propertyList[i]).sort(),
                wrapperClass = propertyList[i].toLowerCase(),
                wrapperSelector = '.' + wrapperClass,
                wrapper = '<div class="filter ' + wrapperClass + '"></div>';
            $('nav').append(wrapper);
            if (values.length > 1) {
                PF.filter.addFormInput('select', wrapperSelector, values, propertyList[i]);
            }
        }
    },
    

    // creates a form input (select or multi-select) based 
    addFormInput: function (tag, selector, values, filter) {
        if (tag === 'select' || tag === 'multiple') {
            var $tag = $('<select/>')
                    .attr('data-filter', filter),
                filterNormal = filter
                    .replace(/([A-Z])/g, ' $1')
                    .replace(/^./, function (str) {
                        return str.toUpperCase();
                    }),
                $label = $('<label/>').html(filterNormal);
            if (tag === 'multiple') {
                $tag.attr('multiple', true);
            }
            $.each(values, function (a, b) {
                $tag.append($('<option/>').attr('value', b).text(b));
            });
            $tag.prepend($('<option/>').attr('value', 'all').text('All'));
            $(selector).append($label).append($tag);
        } else {
            return false;
        }
    },
    
    
    // update the display based on form values
    updateUsingForm: function (filter) {
        var array = [],
            enabled = {},
            features = featureLayer.getGeoJSON().features;
        $.each($('.filter select'), function (key, value) {
            array.push(value);
        });
        $.each($('.filter input'), function(key, value) {
            array.push(value);
        });
        for (var i = 0; i < features.length; i++) {
            var featureState = true;
            for (var j = 0; j < array.length; j++) {
                if ($(array[j]).val() === 'all') {
                    return true;
                } else if ((features[i].properties[$(array[j]).data('filter')] !== $(array[j]).val())) {
                    featureState = false;
                }
            }
            if (featureState === true) {
                enabled[features[i].properties[filter]] = true;
            }
        }
        PF.filter.within(filter, enabled);
    }

};