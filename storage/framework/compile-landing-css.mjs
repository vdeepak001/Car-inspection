import { compile } from '@tailwindcss/node';
import fs from 'node:fs';
import path from 'node:path';

const root = process.cwd();
const inputPath = path.join(root, 'resources/css/app.css');
const input = fs.readFileSync(inputPath, 'utf8');

const compiler = await compile(input, {
    base: root,
    from: inputPath,
    onDependency() {},
});

let candidates = [];

try {
    const { Scanner } = await import('@tailwindcss/oxide');
    const scanner = new Scanner({
        sources: compiler.sources.map((source) => ({
            base: source.base,
            pattern: source.pattern,
            negated: source.negated,
        })),
    });
    candidates = scanner.scan();
} catch (error) {
    console.error('Scanner unavailable, reading class attributes directly.', error.message);
    candidates = collectClassAttributes(path.join(root, 'resources'));
}

const css = compiler.build(candidates);
const assetDirectory = path.join(root, 'public/build/assets');

fs.mkdirSync(assetDirectory, { recursive: true });
fs.writeFileSync(path.join(assetDirectory, 'app.css'), css);
fs.writeFileSync(path.join(assetDirectory, 'app.js'), '');

const manifest = {
    'resources/css/app.css': {
        file: 'assets/app.css',
        src: 'resources/css/app.css',
        isEntry: true,
        name: 'app',
        names: ['app.css'],
    },
    'resources/js/app.js': {
        file: 'assets/app.js',
        src: 'resources/js/app.js',
        isEntry: true,
        name: 'app',
        names: ['app.js'],
    },
};

fs.writeFileSync(path.join(root, 'public/build/manifest.json'), JSON.stringify(manifest, null, 2));

console.log(`Compiled ${candidates.length} candidates into public/build/assets/app.css (${css.length} bytes).`);

function collectClassAttributes(directory) {
    const found = new Set();

    for (const entry of fs.readdirSync(directory, { withFileTypes: true })) {
        const fullPath = path.join(directory, entry.name);

        if (entry.isDirectory()) {
            for (const candidate of collectClassAttributes(fullPath)) {
                found.add(candidate);
            }

            continue;
        }

        if (!entry.name.endsWith('.blade.php') && !entry.name.endsWith('.js')) {
            continue;
        }

        const contents = fs.readFileSync(fullPath, 'utf8');
        const pattern = /class="([^"]+)"/g;
        let match = pattern.exec(contents);

        while (match !== null) {
            for (const candidate of match[1].split(/\s+/)) {
                if (candidate !== '' && !candidate.includes('{{')) {
                    found.add(candidate);
                }
            }

            match = pattern.exec(contents);
        }
    }

    return [...found];
}
