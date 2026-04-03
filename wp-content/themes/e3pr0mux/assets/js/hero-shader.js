/* E3pr0mUX — hero-shader.js
   WebGL fluid noise shader con domain warping
   Nessuna dipendenza esterna. */
(function () {
  'use strict';

  const canvas = document.getElementById('e3-shader-canvas');
  if (!canvas) return;

  const gl = canvas.getContext('webgl') || canvas.getContext('experimental-webgl');
  if (!gl) { canvas.style.display = 'none'; return; }

  /* ── Shaders ──────────────────────────────────────── */
  const VS = `
    attribute vec2 a_pos;
    void main() {
      gl_Position = vec4(a_pos, 0.0, 1.0);
    }
  `;

  const FS = `
    precision highp float;

    uniform float u_time;
    uniform vec2  u_res;
    uniform vec2  u_mouse;

    /* ── Hash + gradient noise ── */
    vec2 hash2(vec2 p) {
      p = vec2(dot(p, vec2(127.1, 311.7)),
               dot(p, vec2(269.5, 183.3)));
      return -1.0 + 2.0 * fract(sin(p) * 43758.5453);
    }

    float gnoise(vec2 p) {
      vec2 i = floor(p);
      vec2 f = fract(p);
      vec2 u = f * f * (3.0 - 2.0 * f);
      return mix(
        mix(dot(hash2(i + vec2(0,0)), f - vec2(0,0)),
            dot(hash2(i + vec2(1,0)), f - vec2(1,0)), u.x),
        mix(dot(hash2(i + vec2(0,1)), f - vec2(0,1)),
            dot(hash2(i + vec2(1,1)), f - vec2(1,1)), u.x),
        u.y
      );
    }

    /* ── FBM ── */
    float fbm(vec2 p) {
      float v = 0.0, a = 0.5;
      for (int i = 0; i < 6; i++) {
        v += a * gnoise(p);
        p *= 2.1;
        a *= 0.48;
      }
      return v;
    }

    void main() {
      vec2 uv    = gl_FragCoord.xy / u_res;
      uv.y       = 1.0 - uv.y;
      float t    = u_time * 0.10;

      /* Mouse attraction */
      vec2  mUv  = u_mouse / u_res;
      mUv.y      = 1.0 - mUv.y;
      float mDst = length(uv - mUv);
      float mInf = exp(-mDst * 4.0) * 0.35;

      /* Domain warping — 3 layers */
      vec2 p = uv * 2.8 + vec2(0.1);

      vec2 q = vec2(
        fbm(p + vec2(0.00, 0.00) + t),
        fbm(p + vec2(5.20, 1.30) + t)
      );

      vec2 r = vec2(
        fbm(p + 4.0 * q + vec2(1.70, 9.20) + 0.14 * t + mInf),
        fbm(p + 4.0 * q + vec2(8.30, 2.80) + 0.12 * t + mInf)
      );

      float f = fbm(p + 4.0 * r);
      f = clamp(f * 0.5 + 0.5, 0.0, 1.0);

      /* Color palette */
      vec3 base   = vec3(0.028, 0.028, 0.028);   /* #070707  */
      vec3 dark   = vec3(0.10,  0.01,  0.02);    /* dark red */
      vec3 accent = vec3(1.00,  0.09,  0.27);    /* #ff1744  */

      vec3 col = mix(base, dark, smoothstep(0.3, 0.65, f));
      col      = mix(col, accent, pow(max(f - 0.55, 0.0) * 2.2, 3.0) * 0.75);

      /* Subtle shimmer along edges */
      float shimmer = gnoise(uv * 18.0 + t * 0.8) * 0.03;
      col += shimmer * accent * smoothstep(0.45, 0.7, f);

      /* Vignette */
      float vig = 1.0 - dot(uv - 0.5, uv - 0.5) * 1.4;
      col *= clamp(vig, 0.0, 1.0) * 0.6 + 0.4;

      gl_FragColor = vec4(col, 1.0);
    }
  `;

  /* ── Compile ──────────────────────────────────────── */
  function compile(type, src) {
    const s = gl.createShader(type);
    gl.shaderSource(s, src);
    gl.compileShader(s);
    return s;
  }

  const prog = gl.createProgram();
  gl.attachShader(prog, compile(gl.VERTEX_SHADER,   VS));
  gl.attachShader(prog, compile(gl.FRAGMENT_SHADER, FS));
  gl.linkProgram(prog);
  gl.useProgram(prog);

  /* ── Fullscreen quad ─────────────────────────────── */
  const buf = gl.createBuffer();
  gl.bindBuffer(gl.ARRAY_BUFFER, buf);
  gl.bufferData(gl.ARRAY_BUFFER,
    new Float32Array([-1,-1, 1,-1, -1,1, 1,1]),
    gl.STATIC_DRAW
  );
  const aPos = gl.getAttribLocation(prog, 'a_pos');
  gl.enableVertexAttribArray(aPos);
  gl.vertexAttribPointer(aPos, 2, gl.FLOAT, false, 0, 0);

  /* ── Uniforms ────────────────────────────────────── */
  const uTime  = gl.getUniformLocation(prog, 'u_time');
  const uRes   = gl.getUniformLocation(prog, 'u_res');
  const uMouse = gl.getUniformLocation(prog, 'u_mouse');

  /* ── Resize ──────────────────────────────────────── */
  let W = 0, H = 0;
  function resize() {
    const rect = canvas.parentElement.getBoundingClientRect();
    W = Math.floor(rect.width  * devicePixelRatio);
    H = Math.floor(rect.height * devicePixelRatio);
    canvas.width  = W;
    canvas.height = H;
    gl.viewport(0, 0, W, H);
  }
  resize();
  window.addEventListener('resize', resize, { passive: true });

  /* ── Mouse tracking ──────────────────────────────── */
  let mx = W * 0.5, my = H * 0.5;
  // smooth lerp targets
  let tx = mx, ty = my;

  document.addEventListener('mousemove', e => {
    const rect = canvas.getBoundingClientRect();
    tx = (e.clientX - rect.left) * devicePixelRatio;
    ty = (e.clientY - rect.top)  * devicePixelRatio;
  }, { passive: true });

  /* ── Render loop ─────────────────────────────────── */
  let start = null;
  function frame(ts) {
    if (!start) start = ts;
    const t = (ts - start) * 0.001;

    /* Lerp mouse */
    mx += (tx - mx) * 0.06;
    my += (ty - my) * 0.06;

    gl.uniform1f(uTime,  t);
    gl.uniform2f(uRes,   W, H);
    gl.uniform2f(uMouse, mx, my);
    gl.drawArrays(gl.TRIANGLE_STRIP, 0, 4);

    requestAnimationFrame(frame);
  }
  requestAnimationFrame(frame);

})();
