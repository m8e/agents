module.exports = {
    plugins: [
        require("tailwindcss"),
        require("autoprefixer"),
        require("franken-ui/postcss/sort-media-queries")({
            sort: "mobile-first",
        }),
        require("franken-ui/postcss/combine-duplicated-selectors")({
            removeDuplicatedProperties: true,
        }),
    ],
};
