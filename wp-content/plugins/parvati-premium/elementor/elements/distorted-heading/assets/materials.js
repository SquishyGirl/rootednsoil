(function(Blotter) {

  Blotter.ChannelSplitMaterial = function() {
    Blotter.Material.apply(this, arguments);
  };

  Blotter.ChannelSplitMaterial.prototype = Object.create(Blotter.Material.prototype);

  Blotter._extendWithGettersSetters(Blotter.ChannelSplitMaterial.prototype, (function () {

    function _mainImageSrc () {
      var mainImageSrc = [
        Blotter.Assets.Shaders.PI,
        Blotter.Assets.Shaders.LineMath,
        Blotter.Assets.Shaders.Random,


        "const int MAX_STEPS = 200;",


        "// Fix a floating point number to two decimal places",
        "float toFixedTwo(float f) {",
        "    return float(int(f * 100.0)) / 100.0;",
        "}",


        "vec2 motionBlurOffsets(vec2 fragCoord, float deg, float spread) {",

        "    // Setup",
        "    // -------------------------------",

        "    vec2 centerUv = vec2(0.5);",
        "    vec2 centerCoord = uResolution.xy * centerUv;",

        "    deg = toFixedTwo(deg);",
        "    float slope = normalizedSlope(slopeForDegrees(deg), uResolution.xy);",


        "    // Find offsets",
        "    // -------------------------------",

        "    vec2 k = offsetsForCoordAtDistanceOnSlope(spread, slope);",
        "    if (deg <= 90.0 || deg >= 270.0) {",
        "        k *= -1.0;",
        "    }",


        "    return k;",
        "}",


        "float noiseWithWidthAtUv(float width, vec2 uv) {",
        "    float noiseModifier = 1.0;",
        "    if (uAnimateNoise > 0.0) {",
        "        noiseModifier = sin(uGlobalTime);",
        "    }",

        "    vec2 noiseRowCol = floor((uv * uResolution.xy) / width);",
        "    vec2 noiseFragCoord = ((noiseRowCol * width) + (width / 2.0));",
        "    vec2 noiseUv = noiseFragCoord / uResolution.xy;",

        "    return random(noiseUv * noiseModifier) * 0.125;",
        "}",


        "vec4 motionBlur(vec2 uv, vec2 blurOffset, float maxOffset) {",
        "    float noiseWidth = 3.0;",
        "    float randNoise = noiseWithWidthAtUv(noiseWidth, uv);",

        "    vec4 result = textTexture(uv);",

        "    float maxStepsReached = 0.0;",

        "    // Note: Step by 2 to optimize performance. We conceal lossiness here via applied noise.",
        "    //   If you do want maximum fidelity, change `i += 2` to `i += 1` below.",
        "    for (int i = 1; i <= MAX_STEPS; i += 2) {",
        "        if (abs(float(i)) > maxOffset) { break; }",
        "        maxStepsReached += 1.0;",

        "        // Divide blurOffset by 2.0 so that motion blur starts half way behind itself",
        "        //   preventing blur from shoving samples in any direction",
        "        vec2 offset = (blurOffset / 2.0) - (blurOffset * (float(i) / maxOffset));",
        "        vec4 stepSample = textTexture(uv + (offset / uResolution.xy));",,

        "        result += stepSample;",
        "    }",

        "    if (maxOffset >= 1.0) {",
        "        result /= maxStepsReached;",
        "        //result.a = pow(result.a, 2.0); // Apply logarithmic smoothing to alpha",
        "        result.a -= (randNoise * (1.0 - result.a)); // Apply noise to smoothed alpha",
        "    }",


        "    return result;",
        "}",


        "void mainImage( out vec4 mainImage, in vec2 fragCoord ) {",

        "    // Setup",
        "    // -------------------------------",

        "    vec2 uv = fragCoord.xy / uResolution.xy;",

        "    float offset = min(float(MAX_STEPS), uResolution.y * uOffset);",

        "    float slope = normalizedSlope(slopeForDegrees(uRotation), uResolution);",

        "    // We want the blur to be the full offset amount in each direction",
        "    //   and to adjust with our logarithmic adjustment made later, so multiply by 4",
        "    float adjustedOffset = offset;// * 4.0;",

        "    vec2 blurOffset = motionBlurOffsets(fragCoord, uRotation, adjustedOffset);",


        "    // Set Starting Points",
        "    // -------------------------------",

        "    vec2 rUv = uv;",
        "    vec2 gUv = uv;",
        "    vec2 bUv = uv;",

        "    vec2 k = offsetsForCoordAtDistanceOnSlope(offset, slope) / uResolution;",

        "    if (uRotation <= 90.0 || uRotation >= 270.0) {",
        "        rUv += k;",
        "        bUv -= k;",
        "    }",
        "    else {",
        "        rUv -= k;",
        "        bUv += k;",
        "    }",


        "    // Blur and Split Channels",
        "    // -------------------------------",

        "    vec4 resultR = vec4(0.0);",
        "    vec4 resultG = vec4(0.0);",
        "    vec4 resultB = vec4(0.0);",

        "    if (uApplyBlur > 0.0) {",
        "        resultR = motionBlur(rUv, blurOffset, adjustedOffset);",
        "        resultG = motionBlur(gUv, blurOffset, adjustedOffset);",
        "        resultB = motionBlur(bUv, blurOffset, adjustedOffset);",
        "    } else {",
        "        resultR = textTexture(rUv);",
        "        resultG = textTexture(gUv);",
        "        resultB = textTexture(bUv);",
        "    }",

        "    float a = resultR.a + resultG.a + resultB.a;",

        "    resultR = normalBlend(resultR, uBlendColor);",
        "    resultG = normalBlend(resultG, uBlendColor);",
        "    resultB = normalBlend(resultB, uBlendColor);",



        "    mainImage = vec4(resultR.r, resultG.g, resultB.b, a);",
        "}"
      ].join("\n");

      return mainImageSrc;
    }

    return {

      constructor : Blotter.ChannelSplitMaterial,

      init : function () {
        this.mainImage = _mainImageSrc();
        this.uniforms = {
          uOffset : { type : "1f", value : 0.05 },
          uRotation : { type : "1f", value : 45.0 },
          uApplyBlur : { type : "1f", value : 1.0 },
          uAnimateNoise : { type : "1f", value : 1.0 }
        };
      }
    };

  })());

})(
  this.Blotter
);


(function(Blotter) {

  Blotter.RollingDistortMaterial = function() {
    Blotter.Material.apply(this, arguments);
  };

  Blotter.RollingDistortMaterial.prototype = Object.create(Blotter.Material.prototype);

  Blotter._extendWithGettersSetters(Blotter.RollingDistortMaterial.prototype, (function () {

    function _mainImageSrc () {
      var mainImageSrc = [
        Blotter.Assets.Shaders.PI,
        Blotter.Assets.Shaders.LineMath,
        Blotter.Assets.Shaders.Noise,

        "// Fix a floating point number to two decimal places",
        "float toFixedTwo(float f) {",
        "    return float(int(f * 100.0)) / 100.0;",
        "}",

        "// Via: http://www.iquilezles.org/www/articles/functions/functions.htm",
        "float impulse(float k, float x) {",
        "    float h = k * x;",
        "    return h * exp(1.0 - h);",
        "}",

        "vec2 waveOffset(vec2 fragCoord, float sineDistortSpread, float sineDistortCycleCount, float sineDistortAmplitude, float noiseDistortVolatility, float noiseDistortAmplitude, vec2 distortPosition, float deg, float speed) {",

        "    // Setup",
        "    // -------------------------------",

        "    deg = toFixedTwo(deg);",

        "    float centerDistance = 0.5;",
        "    vec2 centerUv = vec2(centerDistance);",
        "    vec2 centerCoord = uResolution.xy * centerUv;",

        "    float changeOverTime = uGlobalTime * speed;",

        "    float slope = normalizedSlope(slopeForDegrees(deg), uResolution.xy);",
        "    float perpendicularDeg = mod(deg + 90.0, 360.0); // Offset angle by 90.0, but keep it from exceeding 360.0",
        "    float perpendicularSlope = normalizedSlope(slopeForDegrees(perpendicularDeg), uResolution.xy);",


        "    // Find intersects for line with edges of viewport",
        "    // -------------------------------",

        "    vec2 edgeIntersectA = vec2(0.0);",
        "    vec2 edgeIntersectB = vec2(0.0);",
        "    intersectsOnRectForLine(edgeIntersectA, edgeIntersectB, vec2(0.0), uResolution.xy, centerCoord, slope);",
        "    float crossSectionLength = distance(edgeIntersectA, edgeIntersectB);",

        "    // Find the threshold for degrees at which our intersectsOnRectForLine function would flip",
        "    //   intersects A and B because of the order in which it finds them. This is the angle at which",
        "    //   the y coordinate for the hypotenuse of a right triangle whose oposite adjacent edge runs from",
        "    //   vec2(0.0, centerCoord.y) to centerCoord and whose opposite edge runs from vec2(0.0, centerCoord.y) to",
        "    //   vec2(0.0, uResolution.y) exceeeds uResolution.y",
        "    float thresholdDegA = atan(centerCoord.y / centerCoord.x) * (180.0 / PI);",
        "    float thresholdDegB = mod(thresholdDegA + 180.0, 360.0);",

        "    vec2 edgeIntersect = vec2(0.0);",
        "    if (deg < thresholdDegA || deg > thresholdDegB) {",
        "        edgeIntersect = edgeIntersectA;",
        "    } else {",
        "        edgeIntersect = edgeIntersectB;",
        "    }",

        "    vec2 perpendicularIntersectA = vec2(0.0);",
        "    vec2 perpendicularIntersectB = vec2(0.0);",
        "    intersectsOnRectForLine(perpendicularIntersectA, perpendicularIntersectB, vec2(0.0), uResolution.xy, centerCoord, perpendicularSlope); ",
        "    float perpendicularLength = distance(perpendicularIntersectA, perpendicularIntersectA);",

        "    vec2 coordLineIntersect = vec2(0.0);",
        "    lineLineIntersection(coordLineIntersect, centerCoord, slope, fragCoord, perpendicularSlope);",


        "    // Define placement for distortion ",
        "    // -------------------------------",

        "    vec2 distortPositionIntersect = vec2(0.0);",
        "    lineLineIntersection(distortPositionIntersect, distortPosition * uResolution.xy, perpendicularSlope, edgeIntersect, slope);",
        "    float distortDistanceFromEdge = (distance(edgeIntersect, distortPositionIntersect) / crossSectionLength);// + sineDistortSpread;",

        "    float uvDistanceFromDistort = distance(edgeIntersect, coordLineIntersect) / crossSectionLength;",
        "    float noiseDistortVarianceAdjuster = uvDistanceFromDistort + changeOverTime;",
        "    uvDistanceFromDistort += -centerDistance + distortDistanceFromEdge + changeOverTime;",
        "    uvDistanceFromDistort = mod(uvDistanceFromDistort, 1.0); // For sine, keep distance between 0.0 and 1.0",


        "    // Define sine distortion ",
        "    // -------------------------------",

        "    float minThreshold = centerDistance - sineDistortSpread;",
        "    float maxThreshold = centerDistance + sineDistortSpread;",

        "    uvDistanceFromDistort = clamp(((uvDistanceFromDistort - minThreshold)/(maxThreshold - minThreshold)), 0.0, 1.0);",
        "    if (sineDistortSpread < 0.5) {",
        "        // Add smoother decay to sin distort when it isnt taking up the full viewport.",
        "        uvDistanceFromDistort = impulse(uvDistanceFromDistort, uvDistanceFromDistort);",
        "    }",

        "    float sineDistortion = sin(uvDistanceFromDistort * PI * sineDistortCycleCount) * sineDistortAmplitude;",


        "    // Define noise distortion ",
        "    // -------------------------------",

        "    float noiseDistortion = noise(noiseDistortVolatility * noiseDistortVarianceAdjuster) * noiseDistortAmplitude;",
        "    if (noiseDistortVolatility > 0.0) {",
        "        noiseDistortion -= noiseDistortAmplitude / 2.0; // Adjust primary distort so that it distorts in two directions.",
        "    }",
        "    noiseDistortion *= (sineDistortion > 0.0 ? 1.0 : -1.0); // Adjust primary distort to account for sin variance.",


        "    // Combine distortions to find UV offsets ",
        "    // -------------------------------",

        "    vec2 kV = offsetsForCoordAtDistanceOnSlope(sineDistortion + noiseDistortion, perpendicularSlope);",
        "    if (deg <= 0.0 || deg >= 180.0) {",
        "        kV *= -1.0;",
        "    }",


        "    return kV;",
        "}",


        "void mainImage( out vec4 mainImage, in vec2 fragCoord )",
        "{",
        "    // Setup",
        "    // -------------------------------",

        "    vec2 uv = fragCoord.xy / uResolution.xy;",

        "    // Minor hacks to ensure our waves start horizontal and animating in a downward direction by default.",
        "    uRotation = mod(uRotation + 270.0, 360.0);",
        "    uDistortPosition.y = 1.0 - uDistortPosition.y;",


        "    // Distortion",
        "    // -------------------------------",

        "    vec2 offset = waveOffset(fragCoord, uSineDistortSpread, uSineDistortCycleCount, uSineDistortAmplitude, uNoiseDistortVolatility, uNoiseDistortAmplitude, uDistortPosition, uRotation, uSpeed);",

        "    mainImage = textTexture(uv + offset);",
        "}"
      ].join("\n");

      return mainImageSrc;
    }

    return {

      constructor : Blotter.RollingDistortMaterial,

      init : function () {
        this.mainImage = _mainImageSrc();
        this.uniforms = {
            uSineDistortSpread : { type : "1f", value : 0.05 },
            uSineDistortCycleCount : { type : "1f", value : 2.0 },
            uSineDistortAmplitude : { type : "1f", value : 0.25 },
            uNoiseDistortVolatility : { type : "1f", value : 20.0 },
            uNoiseDistortAmplitude : { type : "1f", value : 0.01 },
            uDistortPosition : { type : "2f", value : [0.5, 0.5] },
            uRotation : { type : "1f", value :  170.0 },
            uSpeed : { type : "1f", value : 0.08 }
        };
      }
    };

  })());

})(
  this.Blotter
);


(function(Blotter) {

  Blotter.LiquidDistortMaterial = function() {
    Blotter.Material.apply(this, arguments);
  };

  Blotter.LiquidDistortMaterial.prototype = Object.create(Blotter.Material.prototype);

  Blotter._extendWithGettersSetters(Blotter.LiquidDistortMaterial.prototype, (function () {

    function _mainImageSrc () {
      var mainImageSrc = [
        Blotter.Assets.Shaders.Noise3D,

        "void mainImage( out vec4 mainImage, in vec2 fragCoord )",
        "{",
        "    // Setup ========================================================================",

        "    vec2 uv = fragCoord.xy / uResolution.xy;",
        "    float z = uSeed + uGlobalTime * uSpeed;",

        "    uv += snoise(vec3(uv, z)) * uVolatility;",

        "    mainImage = textTexture(uv);",

        "}"
      ].join("\n");

      return mainImageSrc;
    }

    return {

      constructor : Blotter.LiquidDistortMaterial,

      init : function () {
        this.mainImage = _mainImageSrc();
        this.uniforms = {
          uSpeed : { type : "1f", value : 1.0 },
          uVolatility : { type : "1f", value : 0.15 },
          uSeed : { type : "1f", value : 0.1 }
        };
      }
    };

  })());

})(
  this.Blotter
);


const MathUtils = {
	lineEq: (y2, y1, x2, x1, currentVal) => {
		// y = mx + b 
		var m = (y2 - y1) / (x2 - x1), b = y1 - m * x1;
		return m * currentVal + b;
	},
	lerp: (a, b, n) =>  (1 - n) * a + n * b
};

class Renderer {
	constructor(options, material) {
		this.options = options;
		this.material = material;
		for (let i = 0, len = this.options.uniforms.length; i <= len-1; ++i) {
			this.material.uniforms[this.options.uniforms[i].uniform].value = this.options.uniforms[i].value;
		}
		for (let i = 0, len = this.options.animatable.length; i <= len-1; ++i) {
			this[this.options.animatable[i].prop] = this.options.animatable[i].from;
			this.material.uniforms[this.options.animatable[i].prop].value = this[this.options.animatable[i].prop];
		}
		this.currentScroll = window.pageYOffset;
		this.maxScrollSpeed = 80;
		requestAnimationFrame(() => this.render());
	}
	render() {
		const newScroll = window.pageYOffset;
		const scrolled = Math.abs(newScroll - this.currentScroll);
		for (let i = 0, len = this.options.animatable.length; i <= len-1; ++i) {
			this[this.options.animatable[i].prop] = MathUtils.lerp(this[this.options.animatable[i].prop], Math.min(MathUtils.lineEq(this.options.animatable[i].to, this.options.animatable[i].from, this.maxScrollSpeed, 0, scrolled), this.options.animatable[i].to), this.options.easeFactor);
			this.material.uniforms[this.options.animatable[i].prop].value = this[this.options.animatable[i].prop];
		}
		this.currentScroll = newScroll;
		requestAnimationFrame(() => this.render());
	}
}

class LiquidDistortMaterial {
	constructor(options) {
		this.options = {
			uniforms: [
				{
					uniform: 'uSpeed', 
					value: 0.5
				},
				{
					uniform: 'uVolatility', 
					value: 0
				},
				{
					uniform: 'uSeed', 
					value: 0.4
				}
			],
			animatable: [
				{prop: 'uVolatility', from: 0, to: 0.9}
			],
			easeFactor: 0.05
		};
		Object.assign(this.options, options);
		this.material = new Blotter.LiquidDistortMaterial();
		new Renderer(this.options, this.material);
		return this.material;
	}
}

class RollingDistortMaterial {
	constructor(options) {
		this.options = {
			uniforms: [
				{
					uniform: 'uSineDistortSpread', 
					value: 0.354
				},
				{
					uniform: 'uSineDistortCycleCount', 
					value: 5
				},
				{
					uniform: 'uSineDistortAmplitude', 
					value: 0
				},
				{
					uniform: 'uNoiseDistortVolatility', 
					value: 0
				},
				{
					uniform: 'uNoiseDistortAmplitude', 
					value: 0.168
				},
				{
					uniform: 'uDistortPosition', 
					value: [0.38,0.68]
				},
				{
					uniform: 'uRotation', 
					value: 48
				},
				{
					uniform: 'uSpeed', 
					value: 0.421
				}
			],
			animatable: [
				{prop: 'uSineDistortAmplitude', from: 0, to: 0.5}
			],
			easeFactor: 0.05
		};
		Object.assign(this.options, options);
		this.material = new Blotter.RollingDistortMaterial();
		new Renderer(this.options, this.material);
		return this.material;
	}
}

class ChannelSplitMaterial {
	constructor(options) {
		this.options = {
			uniforms: [
				{
					uniform: 'uOffset', 
					value: 0
				},
				{
					uniform: 'uRotation', 
					value: 90
				},
				{
					uniform: 'uApplyBlur', 
					value: 1.0
				},
				{
					uniform: 'uAnimateNoise', 
					value: 1.0
				}
			],
			animatable: [
				{prop: 'uOffset', from: 0.02, to: 0.8},
				{prop: 'uRotation', from: 90, to: 100}
			],
			easeFactor: 0.05
		};
		Object.assign(this.options, options);
		this.material = new Blotter.ChannelSplitMaterial();
		new Renderer(this.options, this.material);
		return this.material;
	}
}

class Material {
	constructor(type, options = {}) {
		let material;
		switch (type) {
			case 'LiquidDistortMaterial':
				material = new LiquidDistortMaterial(options);
				break;
			case 'RollingDistortMaterial':
				material = new RollingDistortMaterial(options);
				break;
			case 'ChannelSplitMaterial':
				material = new ChannelSplitMaterial(options);
				break;
		}
		return material;
	}
}