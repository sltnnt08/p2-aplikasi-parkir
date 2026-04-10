# Design System: Editorial Precision for Parkirin

## 1. Overview & Creative North Star

**Creative North Star: "The Kinetic Flow"**

Parking systems are often relegated to utilitarian, clunky interfaces. This design system rejects that. We are building "The Kinetic Flow"—a high-end, editorial experience that treats data like a luxury timepiece. By utilizing high-contrast sidebar elements against an airy, layered canvas, we move beyond a "software tool" and into a "management suite."

We break the standard grid through **intentional asymmetry**: large, oversized data points (Display Typography) paired with tight, technical labels. We replace rigid structural lines with tonal depth, creating a UI that feels like stacked sheets of frosted glass rather than a flat webpage.

## 2. Colors & Tonal Architecture

The palette is rooted in deep architectural slates and electric precision blues.

- **Primary (#0058be / #3B82F6):** Used for "Action Energy."
- **Surface Hierarchy (The "No-Line" Rule):**
  Explicitly prohibit 1px solid borders for sectioning. We define boundaries through background color shifts.
    - **Main Background:** `surface` (#f7f9fc).
    - **Secondary Sections:** `surface_container_low` (#f2f4f7).
    - **Content Cards:** `surface_container_lowest` (#ffffff).
- **The Glass & Gradient Rule:** To avoid a "flat" feel, the Primary CTA should not be a flat hex. Use a subtle linear gradient: `primary` to `primary_container`. For floating overlays, use **Glassmorphism**: a 70% opacity on `surface_container_lowest` with a `20px` backdrop-blur.
- **Signature Textures:** Incorporate a subtle 2% noise texture or a very soft gradient overlay on the Sidebar (#1E293B) to provide "visual soul" and depth.

## 3. Typography: The Editorial Voice

We use **Inter** not as a standard sans-serif, but as a Swiss-style typographic tool.

- **Display Scale:** Use `display-lg` (3.5rem) for critical real-time data, like "Available Slots." It should feel authoritative.
- **High Contrast Pairing:** Pair a `display-sm` value with a `label-sm` (all-caps, 1.5px letter spacing) to create a technical, "instrument panel" aesthetic.
- **Hierarchy as Identity:**
    - **Headlines:** Semi-bold, tight tracking (-0.02em) for a premium, dense feel.
    - **Body:** Regular, increased line-height (1.6) for maximum breathability against the light background.

## 4. Elevation & Depth: Tonal Layering

Traditional shadows are too "web 2.0." We use **Ambient Depth**.

- **The Layering Principle:** Depth is achieved by stacking. A `surface_container_lowest` (White) card sits on a `surface_container_low` (Light Grey) background. This creates a soft, natural lift without a single line of CSS border.
- **Ambient Shadows:** When a card needs to "float" (e.g., a hovering ticket detail), use an extra-diffused shadow: `0px 12px 32px rgba(30, 41, 59, 0.06)`. The shadow color is a tint of the Sidebar color, never pure black.
- **The "Ghost Border" Fallback:** If a boundary is required for accessibility, use a "Ghost Border": `outline_variant` (#c2c6d6) at **15% opacity**. It should be felt, not seen.

## 5. Components

### Buttons (The Kinetic Trigger)

- **Primary:** 8px radius. Background: Primary Gradient. Text: `on_primary`.
- **Tertiary (Ghost):** No background, no border. Use `label-md` bold. Only shows a subtle `surface_container_high` background on hover.

### Input Fields (Precision Entry)

- **Radius:** 6px.
- **Styling:** Use a `surface_container_high` background with no border. On focus, transition to a `surface_container_lowest` background with a 1px `primary` Ghost Border (20% opacity).

### Cards & Lists (The Editorial Feed)

- **Rule:** Forbid divider lines.
- **Separation:** Use `32px` of vertical white space or a subtle background shift between list items.
- **Parking Status Chips:** Use high-chroma `success` (#22C55E) or `danger` (#EF4444) with 10% opacity backgrounds and 100% opacity text for a "modern pill" look.

### The "Slot Map" Component

Unique to this app: Use a staggered grid. Occupied spots use `secondary_container`, while available spots use a glassmorphic `primary` tint to draw the eye immediately.

## 6. Do's and Don'ts

### Do

- **Use Whitespace as a Tool:** If a section feels cluttered, don't add a border; add 16px of padding.
- **Maintain WCAG AA:** Ensure all `on_surface` text against `surface` backgrounds maintains a contrast ratio of at least 4.5:1.
- **Embrace Asymmetry:** Align high-level stats to the left and secondary actions to the extreme right to create a sophisticated, non-template layout.

### Don't

- **Don't use 100% Black:** Use `on_surface` (#191c1e) for text. Pure black is too harsh for high-end editorial work.
- **Don't use Default Shadows:** Never use the standard `box-shadow: 0 2px 4px`. It looks cheap. Use the Ambient Shadow spec.
- **Don't Over-Border:** If you see a solid 1px line, delete it and try a background color shift instead.
