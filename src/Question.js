import React from "react";

function Question({ data }) {
	return (
		<div className="sign-up-container">
			<form action="">
				<div className="single-question">
					<h3>title: {data.title.rendered}</h3>
					<label>
						{data.quizzes_meta[option_1]}
						<input type="radio" name="option_1"/>
					</label>

					<label>
						{data.quizzes_meta[option_2]}
						<input type="radio" name="option_2"/>
					</label>
				</div>
			</form>
		</div>
	);
}

export default Question;
