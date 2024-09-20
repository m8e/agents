export default {
    plugins: {
        'tailwindcss/nesting': {},
        tailwindcss: {},
        autoprefixer: {},
        'franken-ui/postcss/sort-media-queries': {
            sort: 'mobile-first',
        },
        'franken-ui/postcss/combine-duplicated-selectors': {
            removeDuplicatedProperties: true,
        },
    },
};
