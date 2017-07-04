var express=require("express"),
    bodyParser=require("body-parser")
	
app=express();

var port=process.env.PORT || 8080;
app.set('view engine', 'ejs');

app.use(express.static('public'));
//app.use(express.static(path.join(process.cwd(), 'public')));

app.use(bodyParser.urlencoded({extended: true}));

var data =  [
			{"id": "0", "photo": "/assets/images/IMG_0136.JPG", "name": "Juste ZINSOU", "function": "Chirurgie Générale/Viscérale", "address": "LOT 436 KPONDEHOU AKPAKPA", "tel": "+22961225908", "description": "En tant que Chirurgien, Dr ZINSOU a servi l'hopital confessionel Auberge de l'amour rédempteur de Dangbo, à l'hopital EL FATEH de Porto-Novo, à la Clinique Mahunan de Porto-Novo. Il a étudié à l'université de Parakou.", "quote": "Le bien ètre du patient."},
			{"id": "1", "photo": "/assets/images/random-avatar7.jpg","name": "Ouzeiph LASSISSI", "function": "Cardiologie", "address": "LOT 436 KPONDEHOU AKPAKPA", "tel": "+22961225908", "description": "En tant que cardiologue Dr Lassisi a servi à l'hopital de Tanguieta. Il a étudié à l'université de Parakou", "quote": "Pour avoir le coeur sur la main, il faut déjà qu'il soit en bonne santé"},
			{"id": "2", "photo": "/assets/images/random-avatar7.jpg","name": "Espérance HOUMENOU", "function": "Chirurgie Pédiatrique", "address": "LOT 436 KPONDEHOU AKPAKPA", "tel": "+22961225908", "description": "Dr HOUMENOU est médecin depuis 2011 option chirurgie pédiatrique. Il fut ses études médicales à la FSS.", "quote": "L'enfant n'est pas un adulte en miniature."},
			{"id": "3", "photo": "/assets/images/random-avatar7.jpg","name": "Renaud AHOLOU", "function": "Gynécologue-Obstetricien", "address": "LOT 436 KPONDEHOU AKPAKPA", "tel": "+22961225908", "description": "En tant que médecin Dr AHOLOU a servi à l'hopital de Tanguieta. Il a fait ses études médicales à l'université de Parakou", "quote": "Plus aucune femme béninoise porteuse de fistule obstétricale"}];

app.get("/", function(req, res){
	res.render("index", {data:data});
});

app.get("/doctors", function(req, res){
	console.log("listing doctors"+ data);
	res.render("doctors", {data:data});
});

app.get("/profile/:id", function(req, res){
	var id = req.params.id;
	console.log("we here "+id);
	res.render("profile", {data:data, id:id});
	//res.send("Show page!!");
});

app.listen(port, function(){
	console.log("server listening on port "+port);
});