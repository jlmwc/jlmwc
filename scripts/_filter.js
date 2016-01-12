// _filter.js
// functions for displaying, hiding, or generating lists of markers


PF.filter = {

    // shows all features
    showAll: function () {
        featureLayer.setFilter(function () {
            return true;
        });
    },

    // hides all features
    showNone: function () {
        featureLayer.setFilter(function () {
            return false;
        });
    },

    // filters by features that have a particular value on a particular property
    // i.e., City: Calgary
    by: function (property, propertyValue) {
        featureLayer.setFilter(function (f) {
            return f.properties[property] === propertyValue;
        });
    },

    // shows markers that have a value within a particular list of properties
    within: function (property, propertyList) {
        featureLayer.setFilter(function (f) {
            return (f.properties[property] in propertyList);
        });
    },

    // creates a list of features that have a particular property, returns an
    // array of features
    makeList: function (featureList, property) {
        var values = [];
        for (var i = 0; i < featureList.length; i++) {
            var value = featureList[i].properties[property],
                indexTest = indexOf.call(values, value);
            if (indexTest < 0) {
                values.push(value);
            }
        }
    },

    // returns a map circle centred on the reference marker containing the stated
    // number of markers
    findNearest: function (numberMarkers, referenceMarker) {
        var markerArray = [],
            searchArea = L.circle([referenceMarker.getLatLng().lat, referenceMarker.getLatLng().lng], markerArray[numberMarkers - 1]);
        featureLayer.eachLayer(function (m) {
            markerArray.push(referenceMarker.getLatLng().distanceTo(m.getLatLng()));
        });
        return searchArea;
    }

};
