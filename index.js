var path = require('path'),
    express=require("express"),
    mysql=require("mysql"),
	bodyParser=require("body-parser")

//Database init
var connection = mysql.createConnection({
					host: "localhost",
					user: "root",
					password: "teddybravoç&",
					database: "sample"
				});

connection.connect(function(err){
	if(err)
		throw err;
	console.log("Database connected!");
});
	
app=express();
app.set('view engine', 'ejs');

//app.use('/assets', express.static(__dirname + '/assets'));
app.use(express.static(path.join(process.cwd(), 'public')));

app.use(bodyParser.urlencoded({extended: true}));

var doctors = [

			{
				id: "0",
				name: "Donatien",
				function: "Gynicologist",
				address: "LOT 436 KPONDEHOU AKPAKPA",
				tel: "+22961225908",
				description: " An obstetrician/gynecologist is a physician specialist " +  
					"who provides medical and surgical care to women and has particular " + 
					"expertise in pregnancy, childbirth, and disorders of the reproductive " +
					"system. This includes preventative care, prenatal care, detection of " +
					"sexually transmitted diseases, Pap test screening, family planning, etc. " + 
					"An obstetrician gynecologist—commonly abbreviated as OBGYN—can serve as " + 
					"a primary physician and often serve as consultants to other physicians. " + 
					"OB/GYNs can have private practices, work in hospital or clinic settings, " + 
					"and maintain teaching positions at university hospitals. OBGYNs may " + 
					"also work public health and preventive medicine administrations."
			},
			{
				id: "1",
				name: "Abou",
				function: "Pedratician",
				address: "LOT 436 KPONDEHOU AKPAKPA",
				tel: "+22961225908",
				description: "As a pediatrician, your main occupational tasks involve "+ 
					"providing medical care to people ranging in age from newborns to young "+ 
					"adults. You are responsible for examining, diagnosing, and treating "+
					"children with a wide variety of injuries and illnesses. You will also "+
					"administer the many immunizations that are available to protect children "+ 
					"from diseases such as hepatitis B, diphtheria, polio, measles, and the "+
					"mumps. Routine check-ups are also part of your common tasks list, with "+
					"the intent of monitoring a child's growth and development from birth "+
					"to adulthood."
			},
			{
				id: "2",
				name: "Deguenon",
				function: "Surgeon",
				address: "LOT 436 KPONDEHOU AKPAKPA",
				tel: "+22961225908",
				description: "Surgeons are medical doctors with additional training to "+
					"perform general or specialized types of surgeries. While surgeons spend "+
					"time preparing for procedures, reviewing files and meeting with patients, "+ 
					"their most critical role is to perform accurately and efficiently in the "+
					"operating room. The average annual salary for surgeons was $230,540 as "+
					"of May 2012, according to the U.S. Bureau of Labor Statistics"
			},
			{
				id: "3",
				name: "Hounou",
				function: "Generalist",
				address: "LOT 436 KPONDEHOU AKPAKPA",
				tel: "+22961225908"
			}
		]

app.get("/", function(req, res){
	res.render("index");
});

app.get("/doctors", function(req, res){

	console.log("listing doctors"+JSON.stringify(doctors));
	res.render("doctors", {doctors:doctors});
});

app.get("/profile/:id", function(req, res){
	var id = req.params.id;
	console.log("we here "+id);
	res.render("profile", {doctors:doctors, id:id});
});

app.listen(8080, "localhost", function(){
	console.log("server listening on port 8080");
});