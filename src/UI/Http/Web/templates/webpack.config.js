const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const TerserWebpackPlugin = require('terser-webpack-plugin');

let path = require('path');
let isDevelopment = true;

const cssLoader = loader => {
    return [
        {
            loader: MiniCssExtractPlugin.loader,
            options: {
                hmr: isDevelopment,
                reloadAll: true
            },
        },
        'css-loader',
        loader
    ];
};

const optimization = () => {
    const config = {};

    if(!isDevelopment) {
        config.minimizer = [
            new OptimizeCssAssetsPlugin(),
            new TerserWebpackPlugin()
        ];
    }

    return config
};

module.exports = {
    context: path.resolve(__dirname, 'src'),
    entry: {
        main: ['@babel/polyfill', './index.ts'],
        admin: ['@babel/polyfill', './admin.ts'],
    },
    output: {
        path: path.resolve(__dirname, './assets/dist'),
        filename: '[name].bundle.js',
        publicPath: '/public/zentlix/main-bundle/assets/dist/'
    },
    resolve: {
        extensions: ['.ts', '.js', '.json']
    },
    optimization: optimization(),
    devtool: isDevelopment ? 'source-map' : '',
    plugins: [
        new MiniCssExtractPlugin({
            filename: '[name].css',
            chunkFilename: '[id].css',
        }),
    ],
    module: {
        rules: [
            {
                test: /\.ts$/,
                exclude: /node_modules/,
                loader: {
                    loader: 'babel-loader',
                    options: {
                        presets: [
                            '@babel/preset-env',
                            '@babel/preset-typescript'
                        ]
                    }
                }
            },
            {
                test: /\.s[ac]ss$/,
                use: cssLoader('sass-loader')
            },
            {
                test: /\.less$/,
                use: cssLoader('less-loader')
            },
            {
                test: /\.(png|jpg|svg|gif)$/,
                use: 'file-loader'
            },
            {
                test: /\.(ttf|woff|woff2|eot)$/,
                use: 'file-loader'
            }
        ]
    }

};