#!/usr/bin/env python3
"""KURD AI — warm/humanized re-colour engine (presentational only).

Two jobs, no markup or data ever touched:

  palette   Read the compiled Tailwind sheet (public/css/kai-tailwind.css) and
            emit public/css/kai-warm-palette.css: the same selectors, same
            specificity, but every cool/neon colour family remapped onto warm
            clay / cacao / dusty-rose / sage / warm-stone ramps. Arbitrary
            colour utilities (bg-[#0a0f1c], shadow-[0_0_25px_rgba(...)]) are
            converted with the hue engine and neon glows are softened.

  recolor   Rewrite the colour literals of the hand-written design sheets in
            place with the same hue engine, so the neon palette is gone at the
            source instead of being fought with overrides. Writes a marker
            comment so a second run is a no-op.

Usage:  python3 scripts/kai-warm.py palette
        python3 scripts/kai-warm.py recolor
"""
import colorsys
import os
import re
import sys

TAILWIND = 'public/css/kai-tailwind.css'
PALETTE_OUT = 'public/css/kai-warm-palette.css'
MARKER = '/* kai-warm: recoloured */'
MARKER_JS = '/* kai-warm: recoloured */'

RECOLOR_FILES = [
    'public/css/kurdai-design.css',
    'public/css/kurdai-nav.css',
    'public/css/kai-cosmos.css',
    'public/css/kai-aurora-pro.css',
    'public/css/kai-hero.css',
    'public/css/kai-tools.css',
    'public/css/kai-courses.css',
    'public/css/kai-unis.css',
    'public/css/kai-news.css',
    'public/css/kai-guide.css',
    'public/css/kai-about.css',
    'public/css/kai-leaderboard.css',
    'public/css/kai-ferga.css',
    'public/css/kai-ferga-learn.css',
    # JS: the hero constellation's colour palette (decoration only — the file
    # holds no non-colour hex literals, verified by diff).
    'public/js/kai-hero.js',
]

# ---------------------------------------------------------------- hue engine
# Cool + neon hues are folded onto a small warm set. Saturation is capped so
# nothing can glow, and near-neutrals pick up a faint warm tint instead of the
# blue-grey cast the old design used.
HUE_MAP = [
    (0, 20, None, 0.70),     # red — semantic (danger); keep hue, desaturate
    (20, 50, None, 0.88),    # orange / amber — already warm, barely touched
    (50, 90, 40, 0.68),      # yellow / lime -> honey
    (90, 150, 92, 0.50),     # green -> olive (keeps "success" reading)
    (150, 176, 92, 0.48),    # emerald / spring / teal-green -> olive
    (176, 258, 22, 0.46),    # teal / cyan / sky / blue / indigo -> terracotta
    (258, 300, 20, 0.42),    # violet / purple / fuchsia -> walnut
    (300, 348, 12, 0.44),    # pink / magenta -> dusty rose
    (348, 361, None, 0.70),  # red wrap
]
SAT_CAP = 0.46
NEUTRAL_HUE = 30.0


def warm_rgb(r, g, b):
    """Map one sRGB triplet (0-255) to its warm counterpart."""
    h, l, s = colorsys.rgb_to_hls(r / 255.0, g / 255.0, b / 255.0)
    hd = h * 360.0
    if s <= 0.10:                      # neutral -> faint warm tint
        hd, s = NEUTRAL_HUE, min(0.075, s + 0.045)
    else:
        for lo, hi, target, factor in HUE_MAP:
            if lo <= hd < hi:
                if target is not None:
                    hd = float(target)
                s = min(s * factor, SAT_CAP)
                break
    nr, ng, nb = colorsys.hls_to_rgb((hd % 360.0) / 360.0, l, s)
    return round(nr * 255), round(ng * 255), round(nb * 255)


def hex_to_rgb(h):
    h = h.lstrip('#')
    if len(h) == 3:
        h = ''.join(c * 2 for c in h)
    return tuple(int(h[i:i + 2], 16) for i in (0, 2, 4))


def rgb_to_hex(r, g, b):
    return '#%02x%02x%02x' % (r, g, b)


HEX8 = re.compile(r'#([0-9a-fA-F]{6})([0-9a-fA-F]{2})\b')
HEX6 = re.compile(r'#([0-9a-fA-F]{6})\b')
HEX3 = re.compile(r'#([0-9a-fA-F]{3})\b')
RGB_FN = re.compile(r'(rgba?)\(\s*(\d+)\s*([, ])\s*(\d+)\s*[, ]\s*(\d+)\s*([,/][^)]*)?\)')


def warm_text(text, skip_neutral_hex=()):
    """Warm every colour literal inside a chunk of CSS/JS text."""
    def h8(m):
        r, g, b = warm_rgb(*hex_to_rgb(m.group(1)))
        return rgb_to_hex(r, g, b) + m.group(2)

    def h6(m):
        if m.group(0).lower() in skip_neutral_hex:
            return m.group(0)
        r, g, b = warm_rgb(*hex_to_rgb(m.group(1)))
        return rgb_to_hex(r, g, b)

    def h3(m):
        raw = m.group(1)
        if raw.lower() in ('fff', '000'):
            return m.group(0)
        r, g, b = warm_rgb(*hex_to_rgb(raw))
        return rgb_to_hex(r, g, b)

    def fn(m):
        r, g, b = warm_rgb(int(m.group(2)), int(m.group(4)), int(m.group(5)))
        sep = m.group(3)
        tail = m.group(6) or ''
        if sep == ' ':
            return '%s(%d %d %d%s)' % (m.group(1), r, g, b, tail)
        return '%s(%d,%d,%d%s)' % (m.group(1), r, g, b, tail)

    text = HEX8.sub(h8, text)
    text = HEX6.sub(h6, text)
    text = HEX3.sub(h3, text)
    text = RGB_FN.sub(fn, text)
    return text


# ------------------------------------------------------- curated warm ramps
RAMPS = {
    # terracotta — the single brand accent (replaces blue/indigo/sky/cyan)
    'clay': {50: '#fdf6f1', 100: '#f8e7db', 200: '#eecfbb', 300: '#e0ad8e',
             400: '#cd8760', 500: '#b96a3f', 600: '#a8492a', 700: '#8a3b23',
             800: '#6d301e', 900: '#57281a', 950: '#2f150e'},
    # walnut (replaces violet/purple/fuchsia)
    'plum': {50: '#faf6f3', 100: '#f1e8e2', 200: '#e0cdc1', 300: '#caab98',
             400: '#b0876f', 500: '#956a50', 600: '#7c5440', 700: '#654436',
             800: '#52382e', 900: '#452f28', 950: '#261915'},
    # dusty rose (replaces pink/rose)
    'rose': {50: '#fdf5f3', 100: '#fae6e1', 200: '#f0c9c0', 300: '#e2a396',
             400: '#cf7b6b', 500: '#b95a49', 600: '#a33a2e', 700: '#872f26',
             800: '#6c2721', 900: '#5a221d', 950: '#31110e'},
    # olive / sage — success + growth (replaces teal/emerald/green/lime)
    'sage': {50: '#f5f7f1', 100: '#e8eee0', 200: '#d1dcc0', 300: '#b0c199',
             400: '#8ba572', 500: '#6b8752', 600: '#4f6b3c', 700: '#405631',
             800: '#35462a', 900: '#2d3b25', 950: '#161f11'},
    # warm stone — all neutrals (replaces slate/gray/zinc/neutral/stone)
    'warm': {50: '#fbf7f1', 100: '#f4ede4', 200: '#e6dcce', 300: '#d2c4b0',
             400: '#a8998a', 500: '#877a6c', 600: '#6a5e51', 700: '#5c5044',
             800: '#3a322a', 900: '#241c15', 950: '#17110c'},
}
FAMILY_MAP = {
    'blue': 'clay', 'indigo': 'clay', 'sky': 'clay', 'cyan': 'clay',
    'violet': 'plum', 'purple': 'plum', 'fuchsia': 'plum',
    'pink': 'rose', 'rose': 'rose',
    'teal': 'sage', 'emerald': 'sage', 'green': 'sage', 'lime': 'sage',
    'slate': 'warm', 'gray': 'warm', 'zinc': 'warm', 'neutral': 'warm',
    'stone': 'warm',
}

PROPS = ('bg|text|border|border-x|border-y|border-t|border-r|border-b|border-l|'
         'border-s|border-e|ring|ring-offset|shadow|from|via|to|fill|stroke|'
         'placeholder|divide|decoration|outline|accent|caret|selection')
FAMS = '|'.join(FAMILY_MAP)
UTIL_FAMILY = re.compile(r'^(?:[a-z0-9-]+:)*(?:' + PROPS + r')-(' + FAMS + r')-(\d{2,3})(?:/\d{1,3})?$')
UTIL_ARBITRARY = re.compile(r'^(?:[a-z0-9-]+:)*(?:' + PROPS + r')-\[')
CLASS_TOK = re.compile(r'\.((?:\\.|[^\s.,:#\[\]()>+~])+)')
HAS_COLOR = re.compile(r'#[0-9a-fA-F]{3,8}\b|rgba?\(')


def unescape(tok):
    return re.sub(r'\\(?:([0-9a-fA-F]{1,6})\s?|(.))', lambda m: m.group(2) or '', tok)


def split_rules(css):
    """Yield (at_prelude|None, selector, body) for every plain rule, in order."""
    i, n, at_stack = 0, len(css), []
    while i < n:
        j = css.find('{', i)
        if j < 0:
            break
        prelude = css[i:j].strip()
        if prelude.startswith('@') and not prelude.startswith(('@font-face', '@keyframes', '@property')):
            at_stack.append(prelude)
            i = j + 1
            continue
        depth, k = 1, j + 1
        while k < n and depth:
            if css[k] == '{':
                depth += 1
            elif css[k] == '}':
                depth -= 1
            k += 1
        if not prelude.startswith('@'):
            yield (at_stack[-1] if at_stack else None), prelude, css[j + 1:k - 1]
        i = k
        while at_stack and i < n and css[i:].lstrip().startswith('}'):
            i = css.index('}', i) + 1
            at_stack.pop()


RGB_SP = re.compile(r'rgb\(\s*(\d+)\s+(\d+)\s+(\d+)\s*(/[^)]*)?\)')
RGB_CM = re.compile(r'rgba?\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*(,[^)]*)?\)')

# neon glow: no offset, wide blur -> replaced by an honest soft drop shadow
GLOW = re.compile(r'(?<![-\w])0 0 (\d{2,3})px (-?\d+px )?(rgba?\([^)]*\)|#[0-9a-fA-F]{3,8})')


def ramp_target(selector):
    """The single warm hex this family-utility rule should paint, or None."""
    found = set()
    for m in CLASS_TOK.finditer(selector):
        hit = UTIL_FAMILY.match(unescape(m.group(1)))
        if hit:
            found.add((hit.group(1), int(hit.group(2))))
    if len(found) != 1:
        return None
    fam, shade = found.pop()
    return RAMPS[FAMILY_MAP[fam]].get(shade)


def is_arbitrary(selector):
    toks = [unescape(m.group(1)) for m in CLASS_TOK.finditer(selector)]
    return any(UTIL_ARBITRARY.match(t) for t in toks) and not any(UTIL_FAMILY.match(t) for t in toks)


def force(body, target):
    r, g, b = hex_to_rgb(target)
    body = RGB_SP.sub(lambda m: 'rgb(%d %d %d%s)' % (r, g, b, m.group(4) or ''), body)
    body = RGB_CM.sub(lambda m: ('rgba(%d,%d,%d%s)' % (r, g, b, m.group(4))) if m.group(4)
                      else 'rgb(%d,%d,%d)' % (r, g, b), body)
    body = HEX6.sub(target, body)
    return body


def soften_glow(body):
    def rep(m):
        blur = min(int(m.group(1)), 26)
        return '0 %dpx %dpx %srgba(70,52,38,.16)' % (max(2, blur // 4), blur, m.group(2) or '')
    return GLOW.sub(rep, body)


def build_palette():
    css = open(TAILWIND, encoding='utf-8').read()
    out = ['/* AUTO-GENERATED by scripts/kai-warm.py palette — do not hand-edit.\n'
           '   Warm re-colour of the compiled Tailwind colour utilities. Selectors and\n'
           '   specificity are copied verbatim; only the painted colours change, so no\n'
           '   markup, class name, category, tool or course is affected. Must load after\n'
           '   kai-tailwind.css. */']
    fam = arb = 0
    current_at = None
    for at, sel, body in split_rules(css):
        target = ramp_target(sel)
        new_body = None
        if target:
            new_body = soften_glow(force(body.strip(), target))
            fam += 1
        elif is_arbitrary(sel) and HAS_COLOR.search(body):
            new_body = soften_glow(warm_text(body.strip()))
            if new_body == body.strip():
                continue
            arb += 1
        if new_body is None:
            continue
        if at != current_at:
            if current_at:
                out.append('}')
            if at:
                out.append(at + '{')
            current_at = at
        out.append('%s{%s}' % (sel, new_body))
    if current_at:
        out.append('}')
    open(PALETTE_OUT, 'w', encoding='utf-8').write('\n'.join(out) + '\n')
    print('palette: %d family rules + %d arbitrary rules -> %s' % (fam, arb, PALETTE_OUT))


def recolor_files():
    for path in RECOLOR_FILES:
        if not os.path.exists(path):
            print('skip (missing)', path)
            continue
        src = open(path, encoding='utf-8').read()
        if MARKER in src:
            print('skip (already warm)', path)
            continue
        out = soften_glow(warm_text(src))
        open(path, 'w', encoding='utf-8').write(MARKER + '\n' + out)
        print('recoloured', path)


def main():
    mode = sys.argv[1] if len(sys.argv) > 1 else ''
    if mode == 'palette':
        build_palette()
    elif mode == 'recolor':
        recolor_files()
    else:
        print(__doc__)
        return 1
    return 0


if __name__ == '__main__':
    sys.exit(main())
