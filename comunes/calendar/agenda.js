function fHoliday(y,m,d) {
	var rE=fGetEvent(y,m,d), r=null;

	// you may have sophisticated holiday calculation set here, following are only simple examples.
	if (m==1&&d==1)
		r=[" Enero 1, "+y+" \n Feliz Año! ",gsAction,"skyblue","red"];
	else if (m==12&&d==25)
		r=[" Diciembre 25, "+y+" \n Feliz Navidad! ",gsAction,"skyblue","red"];
	else if (m==4&&d==19)
		r=[" Abril 19, "+y+" \n Declaración de la Independencia ",gsAction,"skyblue","red"];
		else if (m==5&&d==1)
		r=[" Mayo 1, "+y+" \n Día del Trabajador ",gsAction,"skyblue","red"];
	else if (m==6&&d==24)
		r=[" Junio 24, "+y+" \n Natalicio del Libertador ",gsAction,"skyblue","red"];
	else if (m==7&&d==5)
		r=[" Julio 5, "+y+" \n Firma del Acta de la Independencia ",gsAction,"skyblue","red"];
		else if (m==10&&d==12)
		r=[" Octubre 12, "+y+" \n Día de la Raza ",gsAction,"skyblue","red"];
	
	
	return rE?rE:r;	// favor events over holidays
}


