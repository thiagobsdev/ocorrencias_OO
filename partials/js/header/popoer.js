!(function (t, e) {
  "object" == typeof exports && "undefined" != typeof module
    ? e(exports)
    : "function" == typeof define && define.amd
    ? define(["exports"], e)
    : e(
        ((t =
          "undefined" != typeof globalThis
            ? globalThis
            : t || self).FloatingUICore = {})
      );
})(this, function (t) {
  "use strict";
  const e = ["top", "right", "bottom", "left"],
    n = ["start", "end"],
    i = e.reduce((t, e) => t.concat(e, e + "-" + n[0], e + "-" + n[1]), []),
    o = Math.min,
    r = Math.max,
    a = { left: "right", right: "left", bottom: "top", top: "bottom" },
    l = { start: "end", end: "start" };
  function s(t, e, n) {
    return r(t, o(e, n));
  }
  function f(t, e) {
    return "function" == typeof t ? t(e) : t;
  }
  function c(t) {
    return t.split("-")[0];
  }
  function u(t) {
    return t.split("-")[1];
  }
  function m(t) {
    return "x" === t ? "y" : "x";
  }
  function d(t) {
    return "y" === t ? "height" : "width";
  }
  function g(t) {
    return ["top", "bottom"].includes(c(t)) ? "y" : "x";
  }
  function p(t) {
    return m(g(t));
  }
  function h(t, e, n) {
    void 0 === n && (n = !1);
    const i = u(t),
      o = p(t),
      r = d(o);
    let a =
      "x" === o
        ? i === (n ? "end" : "start")
          ? "right"
          : "left"
        : "start" === i
        ? "bottom"
        : "top";
    return e.reference[r] > e.floating[r] && (a = w(a)), [a, w(a)];
  }
  function y(t) {
    return t.replace(/start|end/g, (t) => l[t]);
  }
  function w(t) {
    return t.replace(/left|right|bottom|top/g, (t) => a[t]);
  }
  function x(t) {
    return "number" != typeof t
      ? (function (t) {
          return { top: 0, right: 0, bottom: 0, left: 0, ...t };
        })(t)
      : { top: t, right: t, bottom: t, left: t };
  }
  function v(t) {
    const { x: e, y: n, width: i, height: o } = t;
    return {
      width: i,
      height: o,
      top: n,
      left: e,
      right: e + i,
      bottom: n + o,
      x: e,
      y: n,
    };
  }
  function b(t, e, n) {
    let { reference: i, floating: o } = t;
    const r = g(e),
      a = p(e),
      l = d(a),
      s = c(e),
      f = "y" === r,
      m = i.x + i.width / 2 - o.width / 2,
      h = i.y + i.height / 2 - o.height / 2,
      y = i[l] / 2 - o[l] / 2;
    let w;
    switch (s) {
      case "top":
        w = { x: m, y: i.y - o.height };
        break;
      case "bottom":
        w = { x: m, y: i.y + i.height };
        break;
      case "right":
        w = { x: i.x + i.width, y: h };
        break;
      case "left":
        w = { x: i.x - o.width, y: h };
        break;
      default:
        w = { x: i.x, y: i.y };
    }
    switch (u(e)) {
      case "start":
        w[a] -= y * (n && f ? -1 : 1);
        break;
      case "end":
        w[a] += y * (n && f ? -1 : 1);
    }
    return w;
  }
  async function A(t, e) {
    var n;
    void 0 === e && (e = {});
    const { x: i, y: o, platform: r, rects: a, elements: l, strategy: s } = t,
      {
        boundary: c = "clippingAncestors",
        rootBoundary: u = "viewport",
        elementContext: m = "floating",
        altBoundary: d = !1,
        padding: g = 0,
      } = f(e, t),
      p = x(g),
      h = l[d ? ("floating" === m ? "reference" : "floating") : m],
      y = v(
        await r.getClippingRect({
          element:
            null ==
              (n = await (null == r.isElement ? void 0 : r.isElement(h))) || n
              ? h
              : h.contextElement ||
                (await (null == r.getDocumentElement
                  ? void 0
                  : r.getDocumentElement(l.floating))),
          boundary: c,
          rootBoundary: u,
          strategy: s,
        })
      ),
      w =
        "floating" === m
          ? { x: i, y: o, width: a.floating.width, height: a.floating.height }
          : a.reference,
      b = await (null == r.getOffsetParent
        ? void 0
        : r.getOffsetParent(l.floating)),
      A = ((await (null == r.isElement ? void 0 : r.isElement(b))) &&
        (await (null == r.getScale ? void 0 : r.getScale(b)))) || {
        x: 1,
        y: 1,
      },
      R = v(
        r.convertOffsetParentRelativeRectToViewportRelativeRect
          ? await r.convertOffsetParentRelativeRectToViewportRelativeRect({
              elements: l,
              rect: w,
              offsetParent: b,
              strategy: s,
            })
          : w
      );
    return {
      top: (y.top - R.top + p.top) / A.y,
      bottom: (R.bottom - y.bottom + p.bottom) / A.y,
      left: (y.left - R.left + p.left) / A.x,
      right: (R.right - y.right + p.right) / A.x,
    };
  }
  function R(t, e) {
    return {
      top: t.top - e.height,
      right: t.right - e.width,
      bottom: t.bottom - e.height,
      left: t.left - e.width,
    };
  }
  function P(t) {
    return e.some((e) => t[e] >= 0);
  }
  function T(t) {
    const e = o(...t.map((t) => t.left)),
      n = o(...t.map((t) => t.top));
    return {
      x: e,
      y: n,
      width: r(...t.map((t) => t.right)) - e,
      height: r(...t.map((t) => t.bottom)) - n,
    };
  }
  (t.arrow = (t) => ({
    name: "arrow",
    options: t,
    async fn(e) {
      const {
          x: n,
          y: i,
          placement: r,
          rects: a,
          platform: l,
          elements: c,
          middlewareData: m,
        } = e,
        { element: g, padding: h = 0 } = f(t, e) || {};
      if (null == g) return {};
      const y = x(h),
        w = { x: n, y: i },
        v = p(r),
        b = d(v),
        A = await l.getDimensions(g),
        R = "y" === v,
        P = R ? "top" : "left",
        T = R ? "bottom" : "right",
        D = R ? "clientHeight" : "clientWidth",
        O = a.reference[b] + a.reference[v] - w[v] - a.floating[b],
        E = w[v] - a.reference[v],
        L = await (null == l.getOffsetParent ? void 0 : l.getOffsetParent(g));
      let k = L ? L[D] : 0;
      (k && (await (null == l.isElement ? void 0 : l.isElement(L)))) ||
        (k = c.floating[D] || a.floating[b]);
      const C = O / 2 - E / 2,
        B = k / 2 - A[b] / 2 - 1,
        H = o(y[P], B),
        S = o(y[T], B),
        F = H,
        j = k - A[b] - S,
        z = k / 2 - A[b] / 2 + C,
        M = s(F, z, j),
        V =
          !m.arrow &&
          null != u(r) &&
          z !== M &&
          a.reference[b] / 2 - (z < F ? H : S) - A[b] / 2 < 0,
        W = V ? (z < F ? z - F : z - j) : 0;
      return {
        [v]: w[v] + W,
        data: {
          [v]: M,
          centerOffset: z - M - W,
          ...(V && { alignmentOffset: W }),
        },
        reset: V,
      };
    },
  })),
    (t.autoPlacement = function (t) {
      return (
        void 0 === t && (t = {}),
        {
          name: "autoPlacement",
          options: t,
          async fn(e) {
            var n, o, r;
            const {
                rects: a,
                middlewareData: l,
                placement: s,
                platform: m,
                elements: d,
              } = e,
              {
                crossAxis: g = !1,
                alignment: p,
                allowedPlacements: w = i,
                autoAlignment: x = !0,
                ...v
              } = f(t, e),
              b =
                void 0 !== p || w === i
                  ? (function (t, e, n) {
                      return (
                        t
                          ? [
                              ...n.filter((e) => u(e) === t),
                              ...n.filter((e) => u(e) !== t),
                            ]
                          : n.filter((t) => c(t) === t)
                      ).filter((n) => !t || u(n) === t || (!!e && y(n) !== n));
                    })(p || null, x, w)
                  : w,
              R = await A(e, v),
              P = (null == (n = l.autoPlacement) ? void 0 : n.index) || 0,
              T = b[P];
            if (null == T) return {};
            const D = h(
              T,
              a,
              await (null == m.isRTL ? void 0 : m.isRTL(d.floating))
            );
            if (s !== T) return { reset: { placement: b[0] } };
            const O = [R[c(T)], R[D[0]], R[D[1]]],
              E = [
                ...((null == (o = l.autoPlacement) ? void 0 : o.overflows) ||
                  []),
                { placement: T, overflows: O },
              ],
              L = b[P + 1];
            if (L)
              return {
                data: { index: P + 1, overflows: E },
                reset: { placement: L },
              };
            const k = E.map((t) => {
                const e = u(t.placement);
                return [
                  t.placement,
                  e && g
                    ? t.overflows.slice(0, 2).reduce((t, e) => t + e, 0)
                    : t.overflows[0],
                  t.overflows,
                ];
              }).sort((t, e) => t[1] - e[1]),
              C =
                (null ==
                (r = k.filter((t) =>
                  t[2].slice(0, u(t[0]) ? 2 : 3).every((t) => t <= 0)
                )[0])
                  ? void 0
                  : r[0]) || k[0][0];
            return C !== s
              ? {
                  data: { index: P + 1, overflows: E },
                  reset: { placement: C },
                }
              : {};
          },
        }
      );
    }),
    (t.computePosition = async (t, e, n) => {
      const {
          placement: i = "bottom",
          strategy: o = "absolute",
          middleware: r = [],
          platform: a,
        } = n,
        l = r.filter(Boolean),
        s = await (null == a.isRTL ? void 0 : a.isRTL(e));
      let f = await a.getElementRects({
          reference: t,
          floating: e,
          strategy: o,
        }),
        { x: c, y: u } = b(f, i, s),
        m = i,
        d = {},
        g = 0;
      for (let n = 0; n < l.length; n++) {
        const { name: r, fn: p } = l[n],
          {
            x: h,
            y: y,
            data: w,
            reset: x,
          } = await p({
            x: c,
            y: u,
            initialPlacement: i,
            placement: m,
            strategy: o,
            middlewareData: d,
            rects: f,
            platform: a,
            elements: { reference: t, floating: e },
          });
        (c = null != h ? h : c),
          (u = null != y ? y : u),
          (d = { ...d, [r]: { ...d[r], ...w } }),
          x &&
            g <= 50 &&
            (g++,
            "object" == typeof x &&
              (x.placement && (m = x.placement),
              x.rects &&
                (f =
                  !0 === x.rects
                    ? await a.getElementRects({
                        reference: t,
                        floating: e,
                        strategy: o,
                      })
                    : x.rects),
              ({ x: c, y: u } = b(f, m, s))),
            (n = -1));
      }
      return { x: c, y: u, placement: m, strategy: o, middlewareData: d };
    }),
    (t.detectOverflow = A),
    (t.flip = function (t) {
      return (
        void 0 === t && (t = {}),
        {
          name: "flip",
          options: t,
          async fn(e) {
            var n, i;
            const {
                placement: o,
                middlewareData: r,
                rects: a,
                initialPlacement: l,
                platform: s,
                elements: m,
              } = e,
              {
                mainAxis: d = !0,
                crossAxis: p = !0,
                fallbackPlacements: x,
                fallbackStrategy: v = "bestFit",
                fallbackAxisSideDirection: b = "none",
                flipAlignment: R = !0,
                ...P
              } = f(t, e);
            if (null != (n = r.arrow) && n.alignmentOffset) return {};
            const T = c(o),
              D = g(l),
              O = c(l) === l,
              E = await (null == s.isRTL ? void 0 : s.isRTL(m.floating)),
              L =
                x ||
                (O || !R
                  ? [w(l)]
                  : (function (t) {
                      const e = w(t);
                      return [y(t), e, y(e)];
                    })(l)),
              k = "none" !== b;
            !x &&
              k &&
              L.push(
                ...(function (t, e, n, i) {
                  const o = u(t);
                  let r = (function (t, e, n) {
                    const i = ["left", "right"],
                      o = ["right", "left"],
                      r = ["top", "bottom"],
                      a = ["bottom", "top"];
                    switch (t) {
                      case "top":
                      case "bottom":
                        return n ? (e ? o : i) : e ? i : o;
                      case "left":
                      case "right":
                        return e ? r : a;
                      default:
                        return [];
                    }
                  })(c(t), "start" === n, i);
                  return (
                    o &&
                      ((r = r.map((t) => t + "-" + o)),
                      e && (r = r.concat(r.map(y)))),
                    r
                  );
                })(l, R, b, E)
              );
            const C = [l, ...L],
              B = await A(e, P),
              H = [];
            let S = (null == (i = r.flip) ? void 0 : i.overflows) || [];
            if ((d && H.push(B[T]), p)) {
              const t = h(o, a, E);
              H.push(B[t[0]], B[t[1]]);
            }
            if (
              ((S = [...S, { placement: o, overflows: H }]),
              !H.every((t) => t <= 0))
            ) {
              var F, j;
              const t = ((null == (F = r.flip) ? void 0 : F.index) || 0) + 1,
                e = C[t];
              if (e)
                return {
                  data: { index: t, overflows: S },
                  reset: { placement: e },
                };
              let n =
                null ==
                (j = S.filter((t) => t.overflows[0] <= 0).sort(
                  (t, e) => t.overflows[1] - e.overflows[1]
                )[0])
                  ? void 0
                  : j.placement;
              if (!n)
                switch (v) {
                  case "bestFit": {
                    var z;
                    const t =
                      null ==
                      (z = S.filter((t) => {
                        if (k) {
                          const e = g(t.placement);
                          return e === D || "y" === e;
                        }
                        return !0;
                      })
                        .map((t) => [
                          t.placement,
                          t.overflows
                            .filter((t) => t > 0)
                            .reduce((t, e) => t + e, 0),
                        ])
                        .sort((t, e) => t[1] - e[1])[0])
                        ? void 0
                        : z[0];
                    t && (n = t);
                    break;
                  }
                  case "initialPlacement":
                    n = l;
                }
              if (o !== n) return { reset: { placement: n } };
            }
            return {};
          },
        }
      );
    }),
    (t.hide = function (t) {
      return (
        void 0 === t && (t = {}),
        {
          name: "hide",
          options: t,
          async fn(e) {
            const { rects: n } = e,
              { strategy: i = "referenceHidden", ...o } = f(t, e);
            switch (i) {
              case "referenceHidden": {
                const t = R(
                  await A(e, { ...o, elementContext: "reference" }),
                  n.reference
                );
                return {
                  data: { referenceHiddenOffsets: t, referenceHidden: P(t) },
                };
              }
              case "escaped": {
                const t = R(await A(e, { ...o, altBoundary: !0 }), n.floating);
                return { data: { escapedOffsets: t, escaped: P(t) } };
              }
              default:
                return {};
            }
          },
        }
      );
    }),
    (t.inline = function (t) {
      return (
        void 0 === t && (t = {}),
        {
          name: "inline",
          options: t,
          async fn(e) {
            const {
                placement: n,
                elements: i,
                rects: a,
                platform: l,
                strategy: s,
              } = e,
              { padding: u = 2, x: m, y: d } = f(t, e),
              p = Array.from(
                (await (null == l.getClientRects
                  ? void 0
                  : l.getClientRects(i.reference))) || []
              ),
              h = (function (t) {
                const e = t.slice().sort((t, e) => t.y - e.y),
                  n = [];
                let i = null;
                for (let t = 0; t < e.length; t++) {
                  const o = e[t];
                  !i || o.y - i.y > i.height / 2
                    ? n.push([o])
                    : n[n.length - 1].push(o),
                    (i = o);
                }
                return n.map((t) => v(T(t)));
              })(p),
              y = v(T(p)),
              w = x(u);
            const b = await l.getElementRects({
              reference: {
                getBoundingClientRect: function () {
                  if (
                    2 === h.length &&
                    h[0].left > h[1].right &&
                    null != m &&
                    null != d
                  )
                    return (
                      h.find(
                        (t) =>
                          m > t.left - w.left &&
                          m < t.right + w.right &&
                          d > t.top - w.top &&
                          d < t.bottom + w.bottom
                      ) || y
                    );
                  if (h.length >= 2) {
                    if ("y" === g(n)) {
                      const t = h[0],
                        e = h[h.length - 1],
                        i = "top" === c(n),
                        o = t.top,
                        r = e.bottom,
                        a = i ? t.left : e.left,
                        l = i ? t.right : e.right;
                      return {
                        top: o,
                        bottom: r,
                        left: a,
                        right: l,
                        width: l - a,
                        height: r - o,
                        x: a,
                        y: o,
                      };
                    }
                    const t = "left" === c(n),
                      e = r(...h.map((t) => t.right)),
                      i = o(...h.map((t) => t.left)),
                      a = h.filter((n) => (t ? n.left === i : n.right === e)),
                      l = a[0].top,
                      s = a[a.length - 1].bottom;
                    return {
                      top: l,
                      bottom: s,
                      left: i,
                      right: e,
                      width: e - i,
                      height: s - l,
                      x: i,
                      y: l,
                    };
                  }
                  return y;
                },
              },
              floating: i.floating,
              strategy: s,
            });
            return a.reference.x !== b.reference.x ||
              a.reference.y !== b.reference.y ||
              a.reference.width !== b.reference.width ||
              a.reference.height !== b.reference.height
              ? { reset: { rects: b } }
              : {};
          },
        }
      );
    }),
    (t.limitShift = function (t) {
      return (
        void 0 === t && (t = {}),
        {
          options: t,
          fn(e) {
            const { x: n, y: i, placement: o, rects: r, middlewareData: a } = e,
              { offset: l = 0, mainAxis: s = !0, crossAxis: u = !0 } = f(t, e),
              d = { x: n, y: i },
              p = g(o),
              h = m(p);
            let y = d[h],
              w = d[p];
            const x = f(l, e),
              v =
                "number" == typeof x
                  ? { mainAxis: x, crossAxis: 0 }
                  : { mainAxis: 0, crossAxis: 0, ...x };
            if (s) {
              const t = "y" === h ? "height" : "width",
                e = r.reference[h] - r.floating[t] + v.mainAxis,
                n = r.reference[h] + r.reference[t] - v.mainAxis;
              y < e ? (y = e) : y > n && (y = n);
            }
            if (u) {
              var b, A;
              const t = "y" === h ? "width" : "height",
                e = ["top", "left"].includes(c(o)),
                n =
                  r.reference[p] -
                  r.floating[t] +
                  ((e && (null == (b = a.offset) ? void 0 : b[p])) || 0) +
                  (e ? 0 : v.crossAxis),
                i =
                  r.reference[p] +
                  r.reference[t] +
                  (e ? 0 : (null == (A = a.offset) ? void 0 : A[p]) || 0) -
                  (e ? v.crossAxis : 0);
              w < n ? (w = n) : w > i && (w = i);
            }
            return { [h]: y, [p]: w };
          },
        }
      );
    }),
    (t.offset = function (t) {
      return (
        void 0 === t && (t = 0),
        {
          name: "offset",
          options: t,
          async fn(e) {
            var n, i;
            const { x: o, y: r, placement: a, middlewareData: l } = e,
              s = await (async function (t, e) {
                const { placement: n, platform: i, elements: o } = t,
                  r = await (null == i.isRTL ? void 0 : i.isRTL(o.floating)),
                  a = c(n),
                  l = u(n),
                  s = "y" === g(n),
                  m = ["left", "top"].includes(a) ? -1 : 1,
                  d = r && s ? -1 : 1,
                  p = f(e, t);
                let {
                  mainAxis: h,
                  crossAxis: y,
                  alignmentAxis: w,
                } = "number" == typeof p
                  ? { mainAxis: p, crossAxis: 0, alignmentAxis: null }
                  : { mainAxis: 0, crossAxis: 0, alignmentAxis: null, ...p };
                return (
                  l && "number" == typeof w && (y = "end" === l ? -1 * w : w),
                  s ? { x: y * d, y: h * m } : { x: h * m, y: y * d }
                );
              })(e, t);
            return a === (null == (n = l.offset) ? void 0 : n.placement) &&
              null != (i = l.arrow) &&
              i.alignmentOffset
              ? {}
              : { x: o + s.x, y: r + s.y, data: { ...s, placement: a } };
          },
        }
      );
    }),
    (t.rectToClientRect = v),
    (t.shift = function (t) {
      return (
        void 0 === t && (t = {}),
        {
          name: "shift",
          options: t,
          async fn(e) {
            const { x: n, y: i, placement: o } = e,
              {
                mainAxis: r = !0,
                crossAxis: a = !1,
                limiter: l = {
                  fn: (t) => {
                    let { x: e, y: n } = t;
                    return { x: e, y: n };
                  },
                },
                ...u
              } = f(t, e),
              d = { x: n, y: i },
              p = await A(e, u),
              h = g(c(o)),
              y = m(h);
            let w = d[y],
              x = d[h];
            if (r) {
              const t = "y" === y ? "bottom" : "right";
              w = s(w + p["y" === y ? "top" : "left"], w, w - p[t]);
            }
            if (a) {
              const t = "y" === h ? "bottom" : "right";
              x = s(x + p["y" === h ? "top" : "left"], x, x - p[t]);
            }
            const v = l.fn({ ...e, [y]: w, [h]: x });
            return { ...v, data: { x: v.x - n, y: v.y - i } };
          },
        }
      );
    }),
    (t.size = function (t) {
      return (
        void 0 === t && (t = {}),
        {
          name: "size",
          options: t,
          async fn(e) {
            const { placement: n, rects: i, platform: a, elements: l } = e,
              { apply: s = () => {}, ...m } = f(t, e),
              d = await A(e, m),
              p = c(n),
              h = u(n),
              y = "y" === g(n),
              { width: w, height: x } = i.floating;
            let v, b;
            "top" === p || "bottom" === p
              ? ((v = p),
                (b =
                  h ===
                  ((await (null == a.isRTL ? void 0 : a.isRTL(l.floating)))
                    ? "start"
                    : "end")
                    ? "left"
                    : "right"))
              : ((b = p), (v = "end" === h ? "top" : "bottom"));
            const R = x - d.top - d.bottom,
              P = w - d.left - d.right,
              T = o(x - d[v], R),
              D = o(w - d[b], P),
              O = !e.middlewareData.shift;
            let E = T,
              L = D;
            if (
              (y ? (L = h || O ? o(D, P) : P) : (E = h || O ? o(T, R) : R),
              O && !h)
            ) {
              const t = r(d.left, 0),
                e = r(d.right, 0),
                n = r(d.top, 0),
                i = r(d.bottom, 0);
              y
                ? (L =
                    w - 2 * (0 !== t || 0 !== e ? t + e : r(d.left, d.right)))
                : (E =
                    x - 2 * (0 !== n || 0 !== i ? n + i : r(d.top, d.bottom)));
            }
            await s({ ...e, availableWidth: L, availableHeight: E });
            const k = await a.getDimensions(l.floating);
            return w !== k.width || x !== k.height
              ? { reset: { rects: !0 } }
              : {};
          },
        }
      );
    });
});
