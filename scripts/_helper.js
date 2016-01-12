// _helper.js
// helper functions


PF.helper = {

    // internal function for sorting numbers
    compareNumber: function (x, y) {
        if (Number.isNan(x) || Number.isNan(y)) {
            return false;
        } else {
            return x - y;
        }
    }

};
