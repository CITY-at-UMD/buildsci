if (window.File && window.FileReader && window.FileList && window.Blob && window.XMLHttpRequest) {
	var TotalArea=0;
	var reader = new FileReader();
	parser = new DOMParser();
				
	// ThreeJS stuff
	// -------------
	// Get DOM element
	var $container = $('.model');
	
	// Scene Size
	var SCREEN_WIDTH = (document.body.offsetWidth*.9-100)*.75-50;
	var	SCREEN_HEIGHT = SCREEN_WIDTH;
	
	//var mouseX = 0, mouseY = 0;

	var VIEW_ANGLE = 60,
	NEAR = 1,
	FAR = 10000;

	var obj;

	// Create a WebGL renderer, camera, and scene
	var renderer = new THREE.WebGLRenderer();
	var scene = new THREE.Scene();
	var camera = new THREE.PerspectiveCamera(VIEW_ANGLE, SCREEN_WIDTH / SCREEN_HEIGHT, NEAR, FAR);
	
	
	
	//New stuff
	var clock = new THREE.Clock();
	scene.add( camera );
	/*
	var controls = new THREE.FirstPersonControls( camera );
	controls.movementSpeed = 1000;
	controls.lookSpeed = 0.1;
	*/
	controls = new THREE.TrackballControls( camera, renderer.domElement );

	controls.rotateSpeed = 1.0;
	controls.zoomSpeed = 1.2;
	controls.panSpeed = 0.2;

	controls.noZoom = false;
	controls.noPan = false;
	
	//              [  a,  s,  d ] 
	controls.keys = [ 65, 83, 68 ]; // [ rotateKey, zoomKey, panKey ]
	
	
	// Set renderer size
	renderer.setSize(SCREEN_WIDTH, SCREEN_HEIGHT);
	
	window.onresize = function() {
		var SCREEN_WIDTH = (document.body.offsetWidth*.9-100)*.75-50;
		var	SCREEN_HEIGHT = SCREEN_WIDTH;
		renderer.setSize(SCREEN_WIDTH, SCREEN_HEIGHT);
	}

	// Attach the render-supplied DOM element
	$container.append(renderer.domElement);
	
	// Set camera position
	camera.position.z = 4000;

	
	// Create a point light
	var pointLight = new THREE.PointLight( 0xFFFFFF );
	
	// Set its position
	pointLight.position.x = 5000;
	pointLight.position.y = 5000;
	pointLight.position.z = 5000;

	// Add light to the scene
	scene.add(pointLight);
	
	function render() {
		/*
		var timer = -0.0002 * Date.now();
		
		camera.position.x += ( mouseX - camera.position.x ) * .05;
		camera.position.y += ( -mouseY - camera.position.y) * .05;
		
		camera.lookAt( scene.position );
		*/
		
		controls.update( clock.getDelta() );
		
		renderer.render( scene, camera );

	}

	function animate() {
		requestAnimationFrame( animate );
		
		render();
	}
	
	function makeobj(xmlstring){
		scene.remove(obj);
		
		//XML Stuff
		// ---------
		xmlDoc = parser.parseFromString(xmlstring,"text/xml");
		var xcoord = new Array();
		var ycoord = new Array();
		var zcoord = new Array();
		
		// String of x y z values
		var coord = xmlDoc.getElementsByTagName("source")[0].childNodes[1].childNodes[0].nodeValue;
		coord = coord.split(" ");
		// Number of elements
		var elements = xmlDoc.getElementsByTagName("source")[0].childNodes[1].getAttribute("count");
		
		for (var count=0, count2=0; count<elements; count=count+3, count2++) {
			ycoord[count2] = coord[count+2];
		
			zcoord[count2] = coord[count+1];
	
			xcoord[count2] = coord[count];
		}
		
		// Triangle coordinates
		var triangles = xmlDoc.getElementsByTagName("triangles")[0].childNodes[3].childNodes[0].nodeValue;
		triangles = triangles.split(" ");
		// Number of triangles
		var telements = xmlDoc.getElementsByTagName("triangles")[0].getAttribute("count");
		telements = telements * 3;
		
		// Make Mesh
		// ---------		
		var geom = new THREE.Geometry();
		
		//Running history
		var xhist = new Array();
		var yhist = new Array();
		var zhist = new Array();
		var triaghist = 0;
		
		TotalArea=0;
		//alert(TotalArea);
	
		for (var count=0; count<telements; count=count+3) {							
			
			var same = false;
			
			for (var i=0; same == false && i < triaghist; i = i+3) 
			{
				if (xhist[i] == xcoord[triangles[count]] && yhist[i] == ycoord[triangles[count]] && zhist[i] == zcoord[triangles[count]]) // first match first
				{
					if (xhist[i+1] == xcoord[triangles[count+1]] && yhist[i+1] == ycoord[triangles[count+1]] && zhist[i+1] == zcoord[triangles[count+1]]) // second match second
					{
						if (xhist[i+2] == xcoord[triangles[count+2]] && yhist[i+2] == ycoord[triangles[count+2]] && zhist[i+2] == zcoord[triangles[count+2]]) // third match third
						{
							same = true;
						}
					}
					else if (xhist[i+1] == xcoord[triangles[count+2]] && yhist[i+1] == ycoord[triangles[count+2]] && zhist[i+1] == zcoord[triangles[count+2]]) // second match third
					{
						if (xhist[i+2] == xcoord[triangles[count+1]] && yhist[i+2] == ycoord[triangles[count+1]] && zhist[i+2] == zcoord[triangles[count+1]]) // third match second
						{
							same = true;
						}
					}
				}
				else if (xhist[i] == xcoord[triangles[count+1]] && yhist[i] == ycoord[triangles[count+1]] && zhist[i] == zcoord[triangles[count+1]]) // first match second
				{
					if (xhist[i+1] == xcoord[triangles[count]] && yhist[i+1] == ycoord[triangles[count]] && zhist[i+1] == zcoord[triangles[count]]) // second match first
					{
						if (xhist[i+2] == xcoord[triangles[count+2]] && yhist[i+2] == ycoord[triangles[count+2]] && zhist[i+2] == zcoord[triangles[count+2]]) // third match third
						{
							same = true;
						}
					}
					else if (xhist[i+1] == xcoord[triangles[count+2]] && yhist[i+1] == ycoord[triangles[count+2]] && zhist[i+1] == zcoord[triangles[count+2]]) // second match third
					{
						if (xhist[i+2] == xcoord[triangles[count]] && yhist[i+2] == ycoord[triangles[count]] && zhist[i+2] == zcoord[triangles[count]]) // third match first
						{
							same = true;
						}
					}
				}
				else if (xhist[i] == xcoord[triangles[count+2]] && yhist[i] == ycoord[triangles[count+2]] && zhist[i] == zcoord[triangles[count+2]]) // first match third
				{
					if (xhist[i+1] == xcoord[triangles[count]] && yhist[i+1] == ycoord[triangles[count]] && zhist[i+1] == zcoord[triangles[count]]) // second match first
					{
						if (xhist[i+2] == xcoord[triangles[count+1]] && yhist[i+2] == ycoord[triangles[count+1]] && zhist[i+2] == zcoord[triangles[count+1]]) // third match second
						{
							same = true;
						}
					}
					else if (xhist[i+1] == xcoord[triangles[count+1]] && yhist[i+1] == ycoord[triangles[count+1]] && zhist[i+1] == zcoord[triangles[count+1]]) // second match second
					{
						if (xhist[i+2] == xcoord[triangles[count]] && yhist[i+2] == ycoord[triangles[count]] && zhist[i+2] == zcoord[triangles[count]]) // third match first
						{
							same = true;
						}
					}
				}
			}							
			
			if (same == false)
			{
				//Find Total Area
				var sidea = Math.sqrt(Math.pow(xcoord[triangles[count]]-xcoord[triangles[count+1]],2)
					+Math.pow(ycoord[triangles[count]]-ycoord[triangles[count+1]],2)
					+Math.pow(zcoord[triangles[count]]-zcoord[triangles[count+1]],2));
				
				var sideb = Math.sqrt(Math.pow(xcoord[triangles[count]]-xcoord[triangles[count+2]],2)
					+Math.pow(ycoord[triangles[count]]-ycoord[triangles[count+2]],2)
					+Math.pow(zcoord[triangles[count]]-zcoord[triangles[count+2]],2));
					
				var sidec = Math.sqrt(Math.pow(xcoord[triangles[count+2]]-xcoord[triangles[count+1]],2)
					+Math.pow(ycoord[triangles[count+2]]-ycoord[triangles[count+1]],2)
					+Math.pow(zcoord[triangles[count+2]]-zcoord[triangles[count+1]],2));
				
				var semip = (sidea+sideb+sidec)/2;
			
				TotalArea = TotalArea + Math.sqrt(semip*(semip-sidea)*(semip-sideb)*(semip-sidec));
				
				//Add current triangle to history
				xhist[triaghist] = xcoord[triangles[count]];
				yhist[triaghist] = ycoord[triangles[count]];
				zhist[triaghist] = zcoord[triangles[count]];
				
				xhist[triaghist+1] = xcoord[triangles[count+1]];
				yhist[triaghist+1] = ycoord[triangles[count+1]];
				zhist[triaghist+1] = zcoord[triangles[count+1]];
				
				xhist[triaghist+2] = xcoord[triangles[count+2]];
				yhist[triaghist+2] = ycoord[triangles[count+2]];
				zhist[triaghist+2] = zcoord[triangles[count+2]];
				
				triaghist = triaghist + 3;
				
				var v1 = new THREE.Vector3(
					xcoord[triangles[count]],
					ycoord[triangles[count]],
					zcoord[triangles[count]]
				);
				var v2 = new THREE.Vector3(
					xcoord[triangles[count+1]],
					ycoord[triangles[count+1]],
					zcoord[triangles[count+1]]
				);
				var v3 = new THREE.Vector3(
					xcoord[triangles[count+2]],
					ycoord[triangles[count+2]],
					zcoord[triangles[count+2]]
				);
				
				geom.vertices.push(new THREE.Vertex(v1));
				geom.vertices.push(new THREE.Vertex(v2));
				geom.vertices.push(new THREE.Vertex(v3));
				
				geom.faces.push(new THREE.Face3(count,count+1,count+2));
			}
		}
		geom.computeFaceNormals();
		
		$('.surface_area').replaceWith('<div class="surface_area">'+TotalArea/12/12+' ft<sup>2</sup></div>');
		//alert("Total Area is " + TotalArea/12/12 + "ft^2");
		
		// Create face object
		obj = new THREE.Mesh(geom, new THREE.MeshLambertMaterial({color: 0x003399, opacity: 1}));
		obj.doubleSided = true;
		
		// Add the obj to the scene
		scene.add(obj);
		
		//document.addEventListener('mousemove', onDocumentMouseMove, false);
		
		// Render scene from camera view
		render();
		animate();
	}
	
	function loadobj(filePath)
	{
		xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET",filePath,false);
		xmlhttp.send(null);
		var fileContent = xmlhttp.responseText;
		makeobj(fileContent);
	}
	
	loadobj("harvard2.dae");
	
	function handleFileSelect(evt) {			

		var files = evt.target.files; // FileList object

		for (var i=0, f; f=files[i]; i++) {
			// Validate that the extension is a dae
			if(/[^.]+$/.exec(f.name) == 'dae') {
				
				// Closure to capture the file information.
				reader.onload = function(e) {					
					makeobj(e.target.result);
				}
				
				reader.readAsText(f);
				
			}
			else {
				// Filetype not supported
			}
		}
	}
	// Setup listeners
	document.getElementById('files').addEventListener('change', handleFileSelect, false);
}
else {
	alert('One or more features are not fully supported in this browser.');
}

