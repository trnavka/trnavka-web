import './styles/editor.scss'
import ctaBlock from './scripts/blocks/dajnato-cta.block.jsx'
import './scripts/metaboxes/CampaignMetabox.jsx'

const {registerBlockType} = window.wp.blocks;

registerBlockType(ctaBlock.name, ctaBlock);

// import roots from '@roots/sage'

/**
 * @see {@link https://bud.js.org/extensions/bud-preset-wordpress/editor-integration/filters}
 */
// roots.register.blocks('@scripts/blocks');
// roots.register.filters('@scripts/filters');

/**
 * @see {@link https://webpack.js.org/api/hot-module-replacement/}
 */
// if (import.meta.webpackHot) {
//     import.meta.webpackHot.accept(console.error);
// }
