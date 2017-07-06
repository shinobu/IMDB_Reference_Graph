/*
 ./webpack.config.js
 */
const path = require('path');

module.exports = {
    entry: './src/js/neo4jQuery.js',
    output: {
        path: path.resolve('src/js'),
        filename: 'neo4jQueryProxy.js'
    },

    devServer: {
        historyApiFallback: true,
        proxy: {
            '/api': {
                target: 'http://localhost:7474/',
                pathRewrite: {"^/api" : ""},
                secure: false,
                changeOrigin: true
            }
        },
        watchOptions: { aggregateTimeout: 300, poll: 1000 },
        headers: {
            "Access-Control-Allow-Origin": "*",
            "Access-Control-Allow-Methods": "GET, POST, PUT, DELETE, PATCH, OPTIONS",
            "Access-Control-Allow-Headers": "X-Requested-With, content-type, Authorization"
        }
    },
}