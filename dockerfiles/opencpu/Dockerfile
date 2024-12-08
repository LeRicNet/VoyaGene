# Use the latest OpenCPU base image
FROM opencpu/rstudio:latest

# Set the working directory
WORKDIR /usr/local/src

# Install R packages
RUN R -e "install.packages(c('Seurat'))"

# Install packages from GitHub
RUN R -e "remotes::install_github(c('lericnet/voyageneR'))"
