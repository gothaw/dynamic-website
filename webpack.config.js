const mode = process.env.NODE_ENV || 'development';

const webpack = require("webpack");
const autoprefixer = require("autoprefixer");
const TerserPlugin = require('terser-webpack-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

const optimization = {
    minimizer: [
        new TerserPlugin(),
        new OptimizeCSSAssetsPlugin({})
    ]
};

const entry = {
    'index': [
        './public/src/js/index.js',
        './public/src/scss/style.scss'
    ]
};

const _module = {
    rules: [
        {
            test: /\.scss$/,
            exclude: /node_modules/,
            use: [
                MiniCssExtractPlugin.loader,
                "css-loader?url=false",
                "postcss-loader",
                "sass-loader"
            ]
        }
    ]
};

const output = {
    filename: 'bundle.js',
    path: __dirname + '/public/dist/js'
};

const plugins = [
    new MiniCssExtractPlugin({
        filename: "../css/main.css"
    }),
    new webpack.LoaderOptionsPlugin({
        options:{
            postcss: [
                autoprefixer()
            ]
        }
    })
];

module.exports = {
    optimization,
    entry,
    mode,
    module: _module,
    output,
    plugins
};