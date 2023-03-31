
// add classes to some gutenberg elements
function addBlockClassName( props, blockType ) {
    if( blockType.name === 'core/paragraph' || blockType.name === 'core/list' || blockType.name === 'core/heading' ){
        if( props.className ){
            let newClass = props.className + ' wp-el';
            props.className = newClass;
        } else {
            props.className = 'wp-el';
        }
    }
    return props;
}
wp.hooks.addFilter(
    'blocks.getSaveContent.extraProps',
    'ama-editor-js/add-block-class-name',
    addBlockClassName
);

var removeDropCap = function(settings, name) {
    if (name !== "core/paragraph") {
        return settings;
    }

    var newSettings = Object.assign({}, settings);

    if (
        newSettings.supports &&
        newSettings.supports.__experimentalFeatures &&
        newSettings.supports.__experimentalFeatures.typography &&
        newSettings.supports.__experimentalFeatures.typography.dropCap
    ) {
        newSettings.supports.__experimentalFeatures.typography.dropCap = false;
    }

    return newSettings;
};
wp.hooks.addFilter(
    "blocks.registerBlockType",
    "sc/gb/remove-drop-cap",
    removeDropCap
);

/*==================== Kutseka-type beat JS ====================*/