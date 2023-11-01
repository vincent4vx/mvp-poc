const path = require('path');

module.exports = {
    mode: "production",
    devtool: "inline-source-map",
    entry: {
        main: "./src/ts/main.ts",
    },
    output: {
        path: path.resolve('./public/assets/js/'),
        filename: "main.js" // <--- Will be compiled to this single file
    },
    resolve: {
        extensions: [".ts", ".js"],
    },
    module: {
        rules: [
            {
                test: /\.tsx?$/,
                loader: "ts-loader"
            }
        ]
    }
};
