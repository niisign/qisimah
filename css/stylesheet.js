import React, {StyleSheet, Dimensions, PixelRatio} from "react-native";
const {width, height, scale} = Dimensions.get("window"),
    vw = width / 100,
    vh = height / 100,
    vmin = Math.min(vw, vh),
    vmax = Math.max(vw, vh);

export default StyleSheet.create({
    "navbar": {
        "backgroundColor": "#f5f5f5",
        "height": 50
    },
    "searchnavbar": {
        "backgroundColor": "#f5f5f5",
        "height": 70
    },
    "searchable": {
        "marginTop": 12
    },
    "navicons": {
        "marginTop": 12
    },
    "house": {
        "height": "100%"
    },
    "searchbox": {
        "fontSize": 16,
        "paddingTop": 10,
        "paddingRight": 10,
        "paddingBottom": 10,
        "paddingLeft": 10,
        "textAlign": "left"
    },
    "footer": {
        "bottom": 0,
        "marginTop": 84
    },
    "footer-links": {
        "marginLeft": 20
    },
    "main-logo": {
        "marginBottom": 24,
        "marginTop": 157
    }
});