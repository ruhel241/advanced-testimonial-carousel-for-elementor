const webpack = require('webpack');
const path = require('path');
let mix = require('laravel-mix');

mix.options({
    progressBar: false
});

// Remove WebpackBar
mix.override((webpackConfig) => {
    webpackConfig.plugins = (webpackConfig.plugins || []).filter((plugin) => {
        return plugin?.constructor?.name !== 'WebpackBarPlugin';
    });
});

// Production optimizations
if (mix.inProduction()) {
    mix.options({
        terser: {
            terserOptions: {
                compress: {
                    drop_console: true,
                },
            },
        },
    });
}

mix.setPublicPath('assets');
mix.setResourceRoot('../');

mix.webpackConfig({
    module: {
        rules: [
            {
                enforce: 'pre',
                test: /\.mjs$/,
                loader: 'eslint-loader',
                exclude: /node_modules/
            }
        ]
    },

    // output: {
    //     publicPath: '/',
    //     chunkLoadingGlobal: 'webpackChunkatcfe'
    // },

    // optimization: {
    //     splitChunks: {
    //         cacheGroups: {
    //             canvg: {
    //                 test: /[\\/]node_modules[\\/]canvg[\\/]/,
    //                 name: 'canvg',
    //                 chunks: 'all',
    //             },
    
    //             dompurify: {
    //                 test: /[\\/]node_modules[\\/]dompurify[\\/]/,
    //                 name: 'dompurify',
    //                 chunks: 'all',
    //             },
    //         },
    //     },
    // },

    plugins: [
        new webpack.IgnorePlugin({
            resourceRegExp: /^\.\/locale$/,
            contextRegExp: /moment$/
        })
    ],

    resolve: {
        extensions: ['*', '.wasm', '.mjs', '.js', '.jsx', '.json', '.vue'],
        alias: {
            //'@Pieces': path.resolve(__dirname, 'resources/admin/Pieces'),
            '@': path.resolve(__dirname, 'resources/admin')
        }
    }
});

module.exports = mix;